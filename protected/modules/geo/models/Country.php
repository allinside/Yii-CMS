<?php

class Country extends ActiveRecordModel
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'countries';
	}


	public function rules()
	{
		return array(
            array('name', 'required'),
			array('name', 'length', 'max'=>50),
            array('name', 'unique', 'attributeName' => 'name', 'className' => 'Country'),
			array('id, name', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
		return array(
			'users' => array(self::HAS_MANY, 'Users', 'nationality_id'),
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);

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


    public function findOrCreate($name)
    {
        $country = $this->findByAttributes(array("name" => trim($name)));
        if ($country)
        {
            return $country->id;
        }
        else
        {
            $country = new Country();
            $country->name = $name;
            $country->save();
            return $country->id;
        }
    }
}