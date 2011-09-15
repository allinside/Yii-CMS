<?php

class NewsController extends BaseController
{
	const PAGE_SIZE = 10;


	public static function actionsTitles() 
	{
	    return array(
	        "View"  => "Просмотр новости",
	        "Index" => "Список новостей"
	    );
	}
	
	
	public function actionView($id) 
	{
		$model = News::model(); 
		
		$news = $model->findByAttributes(array(
			'state' => News::STATE_ACTIVE,
			'id'    => $id
		));

		$news_list = $model->last()->active()->limit(5)->notEqual("id", $id)->findAll();

		$this->render('view', array(
			'news_list' => $news_list,
			'news'      => $news
		));	
	}	

	
	public function actionIndex() 
	{
        $data_provider = new ActiveDataProvider('News');
        //$data_provider->pagination->pageSize = 2;
        //$data_provider->criteria = array('condition' => 'lang = "ru"');

		$this->render('index', array(
            'data_provider' => $data_provider
		));
	}
}
