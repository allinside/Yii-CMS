<?php

class Article extends ActiveRecordModel
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'articles';
	}
	
	
	public function scopes() 
	{
		return array(
			'last'   => array('order' => 'date DESC'),
		);
	}
	

	public function rules()
	{
		return array(
			array('title, text, section_id, lang', 'required'),
			array('date', 'humanDate'),
			array('title', 'length', 'max' => 400),
			array('title, text, date, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
            'section'  => array(self::BELONGS_TO, 'ArticleSection', 'section_id'),
			'files'    => array(self::HAS_MANY, 'ArticleFile', 'article_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'lang')
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('title', $this->title, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('date', $this->date, true);
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
	
	
	public function beforeSave() 
	{
		if (parent::beforeSave()) 
		{
			if (!$this->date) 
			{
				$this->date = date("Y-m-d");
			}
			
			return true;
		}
	}
	
	
	public function delete() 
	{
		foreach ($this->files as $file) 
		{
			$file->delete();
		}
	    	
		parent::delete();
	}


    public function getContent()
    {
        if (Yii::app()->controller->checkAccess('ArticleAdmin_Update'))
        {
            $this->text.= "<br/> <a href='/articles/articleAdmin/update/id/{$this->id}' class='admin_link'>Редактировать</a>";
        }

        return $this->text;
    }
}
