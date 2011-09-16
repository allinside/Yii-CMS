<?php

class MainModule extends WebModule
{
    public static $base_module = true;


    public static function description()
    {
        return 'Главный модуль';
    }


    public static function version()
    {
        return '1.0';
    }


    public static function name()
    {
        return 'Сайт';
    }


	public function init()
	{
		$this->setImport(array(
        	'main.models.*',
            'main.components.*',
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
			return false;
		}
	}


	public static function adminMenu()
	{
        return array(
			'Логирование'      => '/main/logAdmin/view',
			'Действия сайта'   => '/main/SiteActionAdmin/index',
			'Обратная связь'   => '/main/feedbackAdmin/manage',
			'Языки'            => '/main/LanguageAdmin/manage',
			'Добавить язык'    => '/main/LanguageAdmin/create',
            'Настройки'        => '/main/SettingAdmin/manage',
		);
	}
}
