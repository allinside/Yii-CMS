<?php

class Setting extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

    const ELEMENT_TEXT = 'text';

    const ELEMENT_TEXTAREA = 'textarea';

    const ELEMENT_EDITOR = 'editor';


    public static $elements = array(
        self::ELEMENT_TEXT     => "Строка",
        self::ELEMENT_TEXTAREA => "Текст",
        self::ELEMENT_EDITOR   => "Редактор"
    );

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'settings';
	}


	public function rules()
	{
		return array(
			array('code, title, value, element','required'),
			array('code', 'length', 'max'=>50),
			array('title', 'length', 'max'=>100),
			array('element', 'length', 'max'=>8),
            array('value', 'safe'),
			array('id, code, title, element', 'safe', 'on'=>'search')
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('element',$this->element,true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function getAll()
    {
        $result = array();

        $settings = parent::findAll();
        foreach ($settings as $setting)
        {
            $result[$setting->code] = array(
                "title" => $setting->title,
                "value" => $setting->value
            );
        }

        return $result;
    }


    public function get($code)
    {
        $setting = $this->findByAttributes(array("code" => $code));
        if ($setting)
        {
            return $setting->value;
        }
    }
}