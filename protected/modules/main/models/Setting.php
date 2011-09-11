<?php

class Setting extends ActiveRecordModel
{
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
			array('const, title, value, element','required'),
			array('const', 'length', 'max'=>50),
			array('title', 'length', 'max'=>100),
			array('element', 'length', 'max'=>8),
            array('value', 'safe'),
			array('id, const, title, element', 'safe', 'on'=>'search')
		);
	}


	public function relations()
	{
		return array(
            'section' => array(self::BELONGS_TO, 'SettingsSection', 'section_id')
		);
	}


    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['section'] = 'Раздел';

        return $labels;
    }


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('const',$this->const,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('element',$this->element,true);
        $criteria->with = 'section';

        $section_id = Yii::app()->request->getParam('section_id');
        if ($section_id)
        {
            $criteria->condition = 'section_id = ' . $section_id;
        }

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
           'sort'=>array('attributes'=>array(
                'section'=>array(
                    'asc'  => 'section.name',
                    'desc' => 'section.name DESC',
                ),
                'title'
            )),
		));
	}


    public function getAll()
    {
        $result = array();

        $settings = parent::findAll();
        foreach ($settings as $setting)
        {
            $result[$setting->const] = array(
                "title" => $setting->title,
                "value" => $setting->value
            );
        }

        return $result;
    }


    public function get($const)
    {
        $setting = $this->findByAttributes(array("const" => $const));
        if ($setting)
        {
            return $setting->value;
        }
    }
}