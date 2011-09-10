<?php
 
class LogAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "View" => "Просмотр логово"
        );    
    }


    public function actionView()
    {
        $model = new Log('search');
        $model->unsetAttributes();

        if (isset($_GET['Log']))
        {
            $model->attributes = $_GET['Log'];
        }

        $this->render('view', array('model' => $model));
    }
}
