<?php

class YmarketIP extends ActiveRecordModel
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'ymarket_ips';
	}


	public function rules()
	{
		return array(
			array('ip', 'required'),
            array('ip', 'unique', 'className' => get_class($this), 'attributeName' => 'ip'),
			array('ip', 'length', 'max' => 40),
			array('ip, last_date_use', 'safe', 'on' => 'search'),
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

		$criteria->compare('ip', $this->ip, true);
		$criteria->compare('last_date_use', $this->last_date_use, true);

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