<?php

class YmarketProduct extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'ymarket_products';
	}


	public function rules()
	{
		return array(
			array('name', 'required'),
			array('brand_id', 'length', 'max' => 11),
			array('name', 'length', 'max' => 150),
			array('photo', 'length', 'max' => 38),

			array('id, brand_id, name, photo', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'brand' => array(self::BELONGS_TO, 'YmarketBrands', 'brand_id'),
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('brand_id', $this->brand_id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('photo', $this->photo, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}