<?php

class SettingAdminController extends AdminController
{
    public static function actionsTitles() 
    {
        return array(
            'View'   => 'Просмотр настройки',
            'Update' => 'Редактирование настройки',
            'Manage' => 'Управление настройками'
        );
    }
        

	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// $this->performAjaxValidation($model);

		$form = new BaseForm('main.SettingForm', $model);

		if(isset($_POST['Setting']))
		{
			$model->attributes = $_POST['Setting'];
			if($model->save())
            {
                $this->redirect(array('view', 'id'=>$model->id));
            }
		}

		$this->render('update', array(
			'form' => $form	,
		));
	}


	public function actionManage()
	{
		$model = new Setting('search');
		$model->unsetAttributes();

		if(isset($_GET['Setting']))
        {
            $model->attributes = $_GET['Setting'];
        }

		$this->render('manage', array('model' => $model));
	}


	public function loadModel($id)
	{
		$model = Setting::model()->findByPk((int) $id);
		if($model === null)
        {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

		return $model;
	}
}
