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
			array('url', 'required'),
			array('name, yandex_name', 'length', 'max' => 100),
            array('name', 'unique', 'className' => get_class($this), 'attributeName' => 'name'),
            array('url', 'unique', 'className' => get_class($this), 'attributeName' => 'url'),
            array('yandex_name', 'unique', 'className' => get_class($this), 'attributeName' => 'yandex_name'),
			array('url', 'length', 'max' => 250),
            array(
                'url',
                'match',
                'pattern' => '|http\:\/\/market\.yandex\.ru\/catalogmodels\.xml\?CAT_ID=[0-9]+.*?|',
                'message' => 'Формат: http://market.yandex.ru/catalogmodels.xml?CAT_ID=.....'
            ),
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


    public function parseAndUpdate()
    {
        //$content = YmarketIP::model()->doRequest($this->url);
        $content = file_get_contents("/var/www/SectionContent.html");

        preg_match('|<h1>(.*?)</h1>|', $content, $yandex_name);
        if (isset($yandex_name[1]))
        {
            Yii::log(
                'Ymarket:: не могу спарсить название раздела ' . $this->url,
                'error',
                'ymarket'
            );
            return;
        }

        echo $this->yandex_name = trim($yandex_name[1]);
    }
}