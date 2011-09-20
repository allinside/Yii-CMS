<?php

class BannersModule extends WebModule
{	
	public static $active = true;


    public static function name()
    {
        return 'Баннеры';
    }


    public static function description()
    {
        return 'баннеры';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'banners.models.*',
			'banners.components.*',
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
            'Управление баннерами' => '/banners/bannerAdmin/manage',
            'Добавить баннер'      => '/banners/bannerAdmin/create',
        );
    }
}
