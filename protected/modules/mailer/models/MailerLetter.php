<?php

class MailerLetter extends ActiveRecordModel
{
    const TEXT_PREVIEW_LENGTH = 150;
    

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'mailer_letters';
	}


	public function rules()
	{
		return array(
			array('subject, text', 'required', 'on' => 'without_template'),
			array('template_id', 'length', 'max' => 11),
			array('subject', 'length', 'max' => 150),

			array('id, template_id, subject, text, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'template'   => array(self::BELONGS_TO, 'MailerTemplate', 'template_id'),
			'recipients' => array(self::HAS_MANY, 'MailerRecipient', 'letter_id'),
            'users'      => array(self::HAS_MANY, 'User', 'user_id', 'through' => 'recipients')
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('template_id', $this->template_id, true);
		$criteria->compare('subject', $this->subject, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('date_create', $this->date_create, true);

        $page_size = 10;
        if (isset(Yii::app()->session[get_class($this) . "PerPage"]))
        {
            $page_size = Yii::app()->session[get_class($this) . "PerPage"];
        }

        $this->addLangCondition($criteria);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $page_size,
            ),
		));
	}


    public function getTextContent($preview = false)
    {
        $text = $this->template ? $this->template->text : $this->text;

        if ($preview && mb_strlen($text, 'utf-8') > self::TEXT_PREVIEW_LENGTH)
        {
            $text = mb_substr($text, 0, self::TEXT_PREVIEW_LENGTH, 'utf-8') . '...';
        }

        return $text;
    }


	public function addRecipients($users_ids)
	{
		foreach ($users_ids as $user_id)
        {
            $recipient = MailerRecipient::model()->findByAttributes(array(
                'letter_id' => $this->id,
                'user_id'   => $user_id
            ));

            if ($recipient)
            {
                continue;
            }

        	$recipient = new MailerRecipient;
        	$recipient->letter_id = $this->id;
        	$recipient->user_id   = $user_id;
       		$recipient->save();
        }
	}


	public function deleteRecipients()
	{
    	foreach ($this->recipients as $recipient)
        {
        	$recipient->delete();
        }
	}


    public function updateRecipients($users_ids)
    {
        if ($users_ids)
        {
            $sql = "DELETE FROM " . MailerRecipient::model()->tableName() . "
                           WHERE letter_id = {$this->id} AND
                                 user_id NOT IN (" . implode(',', $users_ids) . ")";

            Yii::app()->db->createCommand($sql)->execute();

            $this->addRecipients($users_ids);
        }
        else
        {
            $this->deleteRecipients();
        }
    }


    public function sendLetters()
    {
        $first_sending = false;

        $model = MailerOption::model();

        $options = MailerOption::model()->getValues();
 
        if (!isset($options['dispatch_time']))
        {
            $dispatch_time = new MailerOption;
            $dispatch_time->name   = 'Последнее время отправки';
            $dispatch_time->code   = 'dispatch_time';
            $dispatch_time->value  = time();
            $dispatch_time->hidden = 1;
            $dispatch_time->save();

            $options['dispatch_time'] = $dispatch_time->value;

            $first_sending = true;
        }
        
        if (!$first_sending && ((time() - $options['dispatch_time']) < $options['timeout']))
        {
            return;
        }
        echo "Начинаем<br/>";
        $letters_sent_count = 0;

        $letters = MailerLetter::model()->findAll(array('order' => 'date_create'));
        foreach ($letters as $letter)
        {

            $recipients = $letter->recipients(array('condition' => "status = '" . MailerRecipient::STATUS_WAITING . "'"));
            if (!$recipients)
            {
                continue;
            }

            $fields = MailerField::model()->findAll();

            foreach ($recipients as $recipient)
            {
                $body   = $letter->template ? $letter->template->text : $letter->text;
                $user   = $recipient->user;
                $codes  = array();
                $values = array();

                foreach ($fields as $field)
                {
                    if (mb_substr($field->value, -1) != ';')
                    {
                        $field->value.= ';';
                    }

                    if (mb_substr($field->value, 0, 7) != 'return ')
                    {
                        $field->value = 'return ' . $field->value;
                    }

                    $value = "";

                    try
                    {
                        $value = @eval($field->value);
                    }
                    catch (CException $e){}

                    $codes[]  = $field->code;
                    $values[] = $value;
                }

                $body = str_replace($codes, $values, $body);
                $body.= "<br><br>" . $options['signature'];
                $body.= "<img src='http://{$_SERVER['HTTP_HOST']}/mailer/Mailer/ConfirmReceipt/letter_id/{$letter->id}/user_id/{$user->id}.jpg' />";
          
                $sent = Mailman::sendMail(
                    $user->email,
                    $letter->template ? $letter->template->subject : $letter->subject,
                    $body,
                    $options['from_name'],
                    $options['reply_address'],
                    $options['host'],
                    $options['port'],
                    $options['login'],
                    $options['password'],
                    $options['encoding'],
                    true
                );

                if ($sent)
                {
                    $recipient->status = MailerRecipient::STATUS_SENT;
                }
                else
                {
                    $recipient->status = MailerRecipient::STATUS_FAIL;
                }

                $recipient->save();

                $letters_sent_count++;

                echo $user->email . "<br/>";

                if ($letters_sent_count >= $options['letters_part_count'])
                {
                    $dispatch_time = MailerOption::model()->findByAttributes(array('code' => 'dispatch_time'));
                    $dispatch_time->value = time();
                    $dispatch_time->save();

                    Yii::app()->end();
                }
            }
        }
    }
}