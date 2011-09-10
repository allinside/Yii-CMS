<?php

class ActionsModule extends WebModule
{
    public static $active = true;


    public static function name()
    {
        return 'Мероприятия';
    }


    public static function description()
    {
        return 'Мероприятия клуба';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'actions.models.*',
			'actions.components.*',
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
            'Все мероприятия'     => '/actions/ActionAdmin/manage',
            'Создать мероприятие' => '/actions/ActionAdmin/create'
        );
    }
}
