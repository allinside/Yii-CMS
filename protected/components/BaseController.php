<?php

abstract class BaseController extends CController
{
	public $layout='//layouts/main';

    public $page_title = '';

    public $meta_title = '';

    public $crumbs = array();
    
    abstract public static function actionsTitles();
    
    
    public function init() 
    {
        parent::init();
        $this->initLanguage();
    }


    private function initLanguage()
    {
		if(isset($_GET['lang']))
		{
			Yii::app()->setLanguage($_GET['lang']);
			Yii::app()->session['language'] = $_GET['lang'];
            Yii::app()->session["admin_panel_lang"] = $_GET['lang'];
		}

		if (!isset(Yii::app()->session['language']) || Yii::app()->session['language'] != Yii::app()->language)
		{
			Yii::app()->session['language'] = Yii::app()->language;
		}
    }
    

    public function beforeAction($action)
    {
        $item_name = AuthItem::constructName($action->controller->id, $action->id);

        if (!$this->checkAccess($item_name))
        {
            $this->forbidden();
        }

        $this->setTitleAndSaveSiteAction($action);
        
        return true;
    }


    private function setTitleAndSaveSiteAction($action)
    {
        $action_titles = call_user_func(array(get_class($action->controller), 'actionsTitles'));

        if (!isset($action_titles[ucfirst($action->id)]))
        {
            throw new CHttpException('Не найден заголовок для дейсвия ' . ucfirst($action->id));
        }

        $title = $action_titles[ucfirst($action->id)];

        $this->page_title = $title;

        $site_action = new SiteAction();
        $site_action->title      = $title;
        $site_action->module     = $action->controller->module->id;
        $site_action->controller = $action->controller->id;
        $site_action->action     = $action->id;

        if (!Yii::app()->user->isGuest)
        {
            $site_action->user_id = Yii::app()->user->id;
        }

        $object_id = $this->request->getParam('id');
        if ($object_id)
        {
            $site_action->object_id = $object_id;
        }

        $site_action->save();
    }

    
    public function checkAccess($item_name)
    {
        if (isset(Yii::app()->user->role->name) && Yii::app()->user->role->name == AuthItem::ROLE_ROOT)
        {   
            return true;
        }

        $auth_item = AuthItem::model()->findByPk($item_name);

        if (!$auth_item)
        {
            Yii::log('Задача $item_name не найдена!');
            return false;
        }

        if ($auth_item->allow_for_all)
        {
            return true;
        }

        if ($auth_item->task)
        {
            if ($auth_item->task->allow_for_all)
            {   
                return true;
            }
        }

        if (Yii::app()->user->checkAccess($auth_item->name))
        {
            return true;
        }

        return false;
        //echo $auth_item->name . '<br/>';
        //echo $auth_item->description . '<br/>';
    }
   

    public function url($route, $params = array(), $ampersand = '&')
    {
        $url_prefix = '/' . Yii::app()->language;

        if ($route != '/')
        {
            if (mb_strpos($route, 'Admin') !== false)
            {
                $url_prefix = null;
            }

            $url = $this->createUrl($route, $params, $ampersand);

            if ($url_prefix)
            {
                $url = '/' . $url_prefix . $url;
            }

            $url = str_replace('//', '/', $url);

            return $url;
        }

        return $route;
    }
    
    
    protected function pageNotFound()
    {
        throw new CHttpException(404,'Страница не найдена!');
    }


    protected function forbidden()
    {
        throw new CHttpException(403, 'Запрещено!');
    }


    public function getRequest()
    {
        return Yii::app()->request;
    }


    public function msg($msg, $type)
    {
        return "<div class='message {$type}' style='display: block;'>
                    <p>{$msg}</p>
                </div>";
    }
}
