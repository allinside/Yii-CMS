<?php

class MainController extends BaseController
{   
    public static function actionsTitles() 
    {
        return array(
            "Error"  => "Ошибка на странице",
            "Search" => "Поиск по сайту"
        );
    }
    

	public function actionSearch($query) 
	{   
	    $this->layout = '//layouts/inner';
	
	    $models = array(
            "News" => array(
                'attributes'   => array("title", "text"),
                'array_var'    => 'news_list',
                'partial_path' => 'application.modules.news.views.news._list'
            ),
            "Article" => array(
                'attributes'   => array("title", "text"),
                'array_var'    => 'articles',
                'partial_path' => 'application.modules.articles.views.article._list'
            ),
            "Action" => array(
                'attributes'   => array("name", "`desc`"),
                'array_var'    => 'actions',
                'partial_path' => 'application.modules.actions.views.action._list'
            ),
            "Document" => array(
                'attributes'   => array("name", "`desc`"),
                'array_var'    => 'documents',
                'partial_path' => 'application.modules.documents.views.document._list'
            ),
            "Faq" => array(
                'attributes'   => array("question", "answer"),
                'array_var'    => 'faqs',
                'partial_path' => 'application.modules.faq.views.faq._list'
            ),    
            "Page" => array(
                'attributes'   => array("title", "text"),
                'array_var'    => 'pages',
                'partial_path' => 'application.modules.content.views.page._list'
            ),                                     
        );
        
        $query = addslashes(strip_tags($query));
        	
	    $result = array();

	    foreach ($models as $class => $data) 
	    {
	        $criteria = new CDbCriteria;
	        
	        foreach ($data['attributes'] as $attribute) 
	        {   
	            $criteria->compare($attribute, $query, true, 'OR');
	        }
	        
	        $model = new $class; 
	        
	        $items = $model->findAll($criteria);
	        if ($items) 
	        {   
	            $data['items']  = $items;
	            $result[$class] = $data;
	        } 
	    }
     
	    $this->render('search', array(
	        'result' => $result,
	        'query'  => $query
	    ));
	}
    
    
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    	{
	    		echo $error['message'];
	    	}
	    	else
	    	{
	        	$this->render('error', $error);
	        }	
	    }
	}
}
