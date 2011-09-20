<?php

class Banner extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'banners';
	}


	public function rules()
	{
		return array(
			array('name, url, title, alt, image, order', 'required'),
			array('is_active, order, date_create', 'numerical', 'integerOnly' => true),
			array('name, title, alt', 'length', 'max' => 250),
			array('url', 'length', 'max' => 500),
			array('image', 'length', 'max' => 38),
            array('image', 'file', 'types' => 'jpg, jpeg, png, gif'),
            array('name', 'unique', 'className' => get_class($this), 'attributeName' => 'name'),
			array('id, name, url, title, alt, image, is_active, order, date_create', 'safe', 'on' => 'search'),
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
		$criteria->compare('name', $this->name, true);
		$criteria->compare('url', $this->url, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('alt', $this->alt, true);
		$criteria->compare('image', $this->image, true);
		$criteria->compare('is_active', $this->is_active);
		$criteria->compare('order', $this->order);
		$criteria->compare('date_create', $this->date_create);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}