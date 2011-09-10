<?php

class MainAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "Index"            => "Просмотр главной страницы",
            "Modules"          => "Просмотр списка модулей",
            "ChangeOrder"      => "Сортировка",
            "SessionPerPage"   => "Установки кол-ва элементов на странице",
            "SessionLanguage"  => "Установка языка"
        );
    }    
    

    public function actionIndex()
    {
        $modules = AppManager::getModulesData(true, true);

        $this->render("index", array('modules' => $modules));
    }
    
    
    public function actionModules()
    {
        $this->render('modules', array(
            'modules'        => AppManager::getModulesData(),
            'active_modules' => AppManager::getActiveModulesArray()
        ));
    }
    

    public function actionChangeOrder($id, $order, $class, $from)
    {
        $model = ActiveRecordModel::model($class);
        $model->changeOrder($id, $order);

        $this->redirect(base64_decode($from));
    }
    

    public function actionSessionPerPage($model, $per_page, $back_url)
    {
        Yii::app()->session["{$model}PerPage"] = $per_page;

        $this->redirect(base64_decode($back_url));
    }


    public function actionSessionLanguage($lang)
    {
        $langs = CHtml::listData(Language::model()->findAll(), "id", "name");

        if (isset($langs[$lang]))
        {
            Yii::app()->session["admin_panel_lang"] = $lang;
        }

        $this->redirect(base64_decode($_GET["back_url"]));
    }
    
    
    
}


        

