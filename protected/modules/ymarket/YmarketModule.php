<?php

class YmarketModule extends WebModule
{	
	public static $active = true;


    public static function name()
    {
        return 'Яндекс маркет';
    }


    public static function description()
    {
        return 'Парсит товары с Яндекс маркета';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'ymarket.models.*',
			'ymarket.components.*',
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
            'Бренды'            => '/ymarket/ymarketBrandAdmin/manage',
            'IP адреса'         => '/ymarket/ymarketIPAdmin/manage',
            'Добавить IP адрес' => '/ymarket/ymarketIPAdmin/create'
        );
    }
}
