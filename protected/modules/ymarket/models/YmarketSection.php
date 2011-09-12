<?php

class YmarketSection extends ActiveRecordModel
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'ymarket_sections';
	}


	public function rules()
	{
		return array(
			array('name, yandex_name, url, breadcrumbs', 'required'),
			array('name, yandex_name', 'length', 'max' => 100),
			array('url', 'length', 'max' => 250),

			array('id, name, yandex_name, url, breadcrumbs, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'ymarketSectionsRels' => array(self::HAS_MANY, 'YmarketSectionsRels', 'section_id'),
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('yandex_name', $this->yandex_name, true);
		$criteria->compare('url', $this->url, true);
		$criteria->compare('breadcrumbs', $this->breadcrumbs, true);
		$criteria->compare('date_create', $this->date_create, true);

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