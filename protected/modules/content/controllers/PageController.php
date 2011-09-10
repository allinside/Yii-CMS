<?php
 
class PageController extends BaseController
{   
    public static function actionsTitles() 
    {
        return array(
            "View" => "Просмотр страницы",
            "Main" => "Главная страница"
        );
    }    
    
    
    public function actionView()
    {       
        $this->layout = '//layouts/inner';           
            
        $id = $this->request->getParam("id");
        if ($id)
        {
            $page = Page::model()->published()->findByPk($id);
            if (!$page || mb_strlen($page->url, 'utf-8') > 0)
            {
                $this->pageNotFound();
            }
        }
        else
        {
            $url = $this->request->getParam("url");
            $page = Page::model()->published()->findByAttributes(array("url" => $url));
            if (!$page)
            {
                $this->pageNotFound();
            }
        }
		
        $this->render("view", array("page" => $page));
    }


    public function actionMain()
    {
        $page = Page::model()->published()->findByAttributes(array('url' => '/'));   

        if (!$page)
        {
            return;
        }

        $this->render('view', array('page' => $page));
    }  
}
