<?php

class MailerOptionAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
        	'Manage' => 'Управление параметрами рассылки',
        	'Update' => 'Редактирование параметра рассылки'
        );
    }


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		$form = new BaseForm('mailer.MailerOptionForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['MailerOption']))
		{
			$model->attributes = $_POST['MailerOption'];
			if($model->save())
            {
                $this->redirect(array('manage'));
            }
		}

		$this->render('update', array(
			'form' => $form,
		));
	}

	
	public function actionManage()
	{
		$model=new MailerOption('search');
		$model->unsetAttributes();
		if(isset($_GET['MailerOption']))
        {
            $model->attributes = $_GET['MailerOption'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = MailerOption::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'mailer-option-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
