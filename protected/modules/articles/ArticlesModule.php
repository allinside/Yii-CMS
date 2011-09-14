<?php

class ArticlesModule extends WebModule
{
    public static $active = true;


    public static function name()
    {
        return 'База знаний';
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
            'articles.controllers.*',
			'articles.models.*',
            'articles.portlets.*',
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
			'Все материалы'     => '/articles/articleAdmin/manage',
			'Добавить материал' => '/articles/articleAdmin/create',
			'Список разделов'   => '/articles/articleSectionAdmin/manage',
			'Добавить раздел'   => '/articles/articleSectionAdmin/create'
        );
    }


    public static function urlRules()
    {
        return array(
            '<lang:[a-z]{2}>/articles'                          => 'articles/article/index',
            '<lang:[a-z]{2}>/articles/<id:\d+>'                 => 'articles/article/view',
            '<lang:[a-z]{2}>/articles/section/<section_id:\d+>' => 'articles/article/SectionArticles',
        );
    }
}
