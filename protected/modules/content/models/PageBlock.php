<?php

class PageBlock extends ActiveRecordModel
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'pages_blocks';
	}


	public function rules()
	{
		return array(
			array('title, text, name, lang', 'required'),
			array('name', 'match', 'pattern' => '|^[a-z_]+$|', 'message' => 'только латиница и знак подчеркивания "_"'),
			array('title', 'length', 'max'=>250),
			array('title', 'unique', 'className' => 'PageBlock', 'attributeName' => 'title'),
			array('name', 'unique', 'className' => 'PageBlock', 'attributeName' => 'name'),
			array('id, title, text, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
		    'language' => array(self::BELONGS_TO, 'Language', 'lang')
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('date_create',$this->date_create,true);

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


    public function getText($name)
    {
        $block = $this->findByAttributes(array("name" => $name));
        if ($block)
        {
            $text = $block["text"];

        	if (Yii::app()->controller->checkAccess('PageAdmin_Update'))
        	{
				$text.= "&nbsp; <a href='/content/pageBlockAdmin/update/id/{$block['id']}' class='admin_link'>Редактировать</a>";
        	}
        
        	return $text;
        }
    }
}
