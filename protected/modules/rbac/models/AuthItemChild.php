<?php

class AuthItemChild extends ActiveRecordModel
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'AuthItemChild';
	}


	public function rules()
	{
		return array(
			array('parent, child', 'required'),
			array('parent, child', 'length', 'max' => 64),

			array('parent, child', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('parent', $this->parent, true);
		$criteria->compare('child', $this->child, true);

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


    /*
     * TODO: replace queryALL
     */
    public function getAllowedTasks($role)
    {
        $tasks = array();

        $sql = "SELECT child
                       FROM " . self::tableName() . "
                       WHERE parent = '{$role}'";

        $result = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($result as $data)
        {
            $tasks[] = $data['child'];
        }

        return $tasks;
    }
}