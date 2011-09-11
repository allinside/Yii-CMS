<?php

class UsersModule extends WebModule
{
	public static $active = true;
		
	
    public static $base_module = true;


    public static function name()
    {
        return 'Пользователи';
    }


    public static function description()
    {
        return 'Пользователи, права доступа';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'users.models.*',
			'users.components.*',
		));
	}


	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
        {

        }
	}


    public static function adminMenu()
    {
        return array(
            'Все пользователи '     => '/users/userAdmin/manage',
            'Добавить пользователя' => '/users/userAdmin/create',
        );
    }


    public static function urlRules()
    {
        return array(
            '<lang:[a-z]{2}>/login'        => 'users/user/login',
            '<lang:[a-z]{2}>/logout'       => 'users/user/logout',
            '<lang:[a-z]{2}>/registration' => 'users/user/registration',
            'admin/login'                  => 'users/userAdmin/login',
        );
    }
}
