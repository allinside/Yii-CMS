<?php

class MailerOption extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'mailer_options';
	}


	public function rules()
	{
		return array(
			array('name, code, value', 'required'),
			array('name, code', 'length', 'max' => 50),
			array('value', 'length', 'max' => 250),
            array('hidden', 'numerical', 'integerOnly' => true),
			array('id, name, code, value', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('code', $this->code, true);
		$criteria->compare('value', $this->value, true);
        $criteria->compare('hidden', 0);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function getValues()
    {
        $result = array();

        $options = $this->findAll();
        foreach ($options as $option)
        {
            $result[$option->code] = $option->value;
        }

        return $result;
    }
}