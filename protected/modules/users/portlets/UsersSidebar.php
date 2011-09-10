<?php

Yii::import('zii.widgets.CPortlet');

class UsersSidebar extends CPortlet
{
    public function renderContent()
    {
        $users = User::model()->last()->limit(6)->findAllByAttributes(array(
            'status'      => User::STATUS_ACTIVE,
            'club_status' => User::CLUB_STATUS_CLUBMAN
        ));
		
		if (!$users) 
		{
			return false;
		}

        $this->render('UsersSidebar', array('users' => $users));
    }
}
