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


	public function search($module_id = null)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('element',$this->element,true);

        if ($module_id)
        {
            $criteria->compare('module_id', $module_id);
        }

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function findCodesValues($module_id)
    {
        $result = array();

        $settings = $this->findAll("module_id = '{$module_id}'");
        foreach ($settings as $setting)
        {
            $result[$setting->code] = $setting->value;
        }

        return $result;
    }
}