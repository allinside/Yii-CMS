<?php

class AuthAssignment extends ActiveRecordModel
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'AuthAssignment';
	}


	public function rules()
	{
		return array(
			array('itemname, userid', 'required'),
			array('itemname, userid', 'length', 'max' => 64),
			array('bizrule, data', 'safe'),

			array('itemname, userid, bizrule, data', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'role' => array(self::BELONGS_TO, 'AuthItem', 'itemname')
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('itemname', $this->itemname, true);
		$criteria->compare('userid', $this->userid, true);
		$criteria->compare('bizrule', $this->bizrule, true);
		$criteria->compare('data', $this->data, true);

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


    public static function updateUserRole($user_id, $role)
    {
        $assignment = AuthAssignment::model()->findByAttributes(array('userid' => $user_id));
        if (!$assignment)
        {
            $assignment = new AuthAssignment();
            $assignment->userid = $user_id;
        }

        $assignment->itemname = $role;
        $assignment->save();
    }
}
