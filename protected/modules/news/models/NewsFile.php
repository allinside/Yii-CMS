<?php

class NewsFile extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

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
			array('news_id, file', 'required'),
			array('id, news_id', 'length', 'max' => 11),
			array(
				'file',
				'file',
                'types'      => 'docx, xls, xlsx, ptt, pptx, pdf, jpg, jpeg, gif, png, bmp, tif',
				'allowEmpty' => true,
				'maxSize'    => 1024 * 1024 * 25,
				'tooLarge'   => 'Максимальный размер файла 25 Мб'
			),
			array('id, news_id, file, created_at', 'safe', 'on' => 'search'),
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
		$criteria->compare('file', $this->file, true);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->condition = "news_id = {$news_id}";

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function delete()
    {
        if ($this->file)
        {
            $file_path = $_SERVER['DOCUMENT_ROOT'] . self::FILES_DIR . $this->file;
            if (file_exists($file_path))
            {
                unlink($file_path);
            }
        }

        parent::delete();
    }
}