<?php
 
class WebUser extends CWebUser
{
    private $_model = null;


    public function getRole()
    {	
        if($user = $this->getModel())
        {
            return $user->role->name;
        }
        else 
        {	
        	return AuthItem::ROLE_GUEST;
        }
    }


    public function isRootRole()
    {
        if($user = $this->getModel())
        {
            return $user->isRootRole();
        }
    }


    public function getName()
    {   
        if ($user = $this->getModel())
        {
            return implode(' ', array(
                $user->last_name ,
                $user->first_name ,
                $user->patronymic
            ));
        }
    }   


    public function getModel()
    {
        if (!$this->isGuest && $this->_model === null)
        {
            $this->_model = User::model()->findByPk($this->id);
        }

        return $this->_model;
    }
}
