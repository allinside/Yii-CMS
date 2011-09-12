<?php

class MailerModule extends WebModule
{	
	public static $active = false;


    public static function name()
    {
        return 'Рассылка';
    }


    public static function description()
    {
        return 'Email рассылка';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'mailer.models.*',
			'mailer.components.*',
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
        	'Отчеты'            => '/mailer/MailerLetterAdmin/manage',
            'Создать рассылку'  => '/mailer/MailerLetterAdmin/create',
        	'Шаблоны'           => '/mailer/MailerTemplateAdmin/manage',
            'Добавить шаблон'   => '/mailer/MailerTemplateAdmin/create',
            'Генерируемые поля' => '/mailer/MailerFieldAdmin/manage',
            'Добавить поле'     => '/mailer/MailerFieldAdmin/create',
            'Параметры'         => '/mailer/MailerOptionAdmin/manage'
        );
    }
}
