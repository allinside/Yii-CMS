<?php

class Language extends ActiveRecordModel
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'languages';
	}


	public function rules()
	{
		return array(
			array('id, name', 'required'),
		    array('id', 'unique', 'className' => 'Language', 'attributeName' => 'id'),
		    array('name', 'unique', 'className' => 'Language', 'attributeName' => 'name'),
			array('id', 'latAlpha'),
			array('id', 'length', 'max' => 2),
			array('name', 'length', 'max' => 15),

			array('id, name', 'safe', 'on' => 'search'),
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
}
