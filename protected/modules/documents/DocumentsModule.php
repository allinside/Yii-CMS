<?php

class DocumentsModule extends WebModule
{	
	public static $active = true;
	
	
    public static function name()
    {
        return 'Уставные документы клуба';
    }


    public static function description()
    {
        return '';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'documents.models.*',
			'documents.components.*',
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
        	'Все документы'     => '/documents/DocumentAdmin/manage',
        	'Добавить документ' => '/documents/DocumentAdmin/create'
        );
    }


    public static function urlRules()
    {
        return array(
            '<lang:[a-z]{2}>/documents'          => 'documents/document/index',
            '<lang:[a-z]{2}>/documents/<id:\d+>' => 'documents/document/view',
        );
    }
}
