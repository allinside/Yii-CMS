<?php

class NewsController extends BaseController
{
	const PAGE_SIZE = 10;


	public $layout='//layouts/inner';
	
	
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
		$model = News::model()->active()->last();

		$criteria = $model->dbCriteria;

		$pages = new CPagination($model->count($criteria));
		$pages->pageSize = self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$news_list = $model->findAll($criteria);
		
		$this->render('index', array(
			'pages' => $pages,
			'news_list'  => $news_list	
		));
	}
}
