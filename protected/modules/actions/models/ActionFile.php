<?php

class ActionFile extends ActiveRecordModel
{
	const FILES_DIR = 'upload/actions_files/';


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'actions_files';
	}


	public function rules()
	{
		return array(
			array('action_id, file', 'required'),
			array('action_id', 'length', 'max' => 11),
			array(
				'file',
				'file',
                'types'      => 'docx, xls, xlsx, ptt, pptx, pdf, jpg, jpeg, gif, png, bmp, tif',
				'allowEmpty' => true,
				'maxSize'    => 1024 * 1024 * 25,
				'tooLarge'   => 'Максимальный размер файла 25 Мб'
			),
			array('id, action_id, file, created_at', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'action' => array(self::BELONGS_TO, 'Action', 'action_id'),
		);
	}


	public function search($action_id)
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('action_id', $this->action_id, true);
		$criteria->compare('file', $this->file, true);
		$criteria->compare('created_at', $this->created_at, true);

        $criteria->condition = "action_id = {$action_id}";

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