<?php

class NewsFile extends ActiveRecordModel
{
	const FILES_DIR = 'upload/news_files/';
	
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'news_files';
	}


	public function rules()
	{
		return array(
			array('news_id, title, file', 'required'),
			array('id, news_id', 'length', 'max' => 11),
			array('title', 'length', 'max' => 250),
			array(
				'file',
				'file',
                'types'      => 'docx, xls, xlsx, ptt, pptx, pdf, jpg, jpeg, gif, png, bmp, tif',
				'allowEmpty' => true,
				'maxSize'    => 1024 * 1024 * 25,
				'tooLarge'   => 'Максимальный размер файла 25 Мб'
			),
			array('id, news_id, title, file, created_at', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'news' => array(self::BELONGS_TO, 'News', 'news_id'),
		);
	}


	public function search($news_id)
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('news_id', $this->news_id, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('file', $this->file, true);
		$criteria->compare('created_at', $this->created_at, true);

		$criteria->condition = "news_id = {$news_id}";

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
	
	
	public function uploadFiles() 
	{
		return array(
			'file' => array('dir' => self::FILES_DIR)
		);
	}
}