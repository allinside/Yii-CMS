<?php

class Log extends ActiveRecordModel
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'log';
	}


	public function rules()
	{
		return array(
			array('level, category', 'length', 'max'=>128),
			array('message', 'safe'),
			array('id, level, category, logtime, message', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
		return array(
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('logtime',$this->logtime);
		$criteria->compare('message',$this->message,true);

        $page_size = 10;
        if (isset(Yii::app()->session[get_class($this) . "PerPage"]))
        {
            $page_size = Yii::app()->session[get_class($this) . "PerPage"];
        }

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $page_size,
            ),
		));
	}
}