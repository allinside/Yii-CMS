<?php

class SiteActionAdminController extends AdminController
{
    public static function actionsTitles() 
    {
        return array(
            "Index" => "Просмотр действий сайта"
        );  
    }


	public function actionIndex()
	{   
		$model=new SiteAction('search');
		$model->unsetAttributes();
		if(isset($_GET['SiteAction']))
        {
            $model->attributes = $_GET['SiteAction'];
        }

		$this->render('index', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = SiteAction::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'site-action-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
