<?php

class MailerFieldAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create' => 'Добавление генерируемого поля',
            'Update' => 'Редактирование генерируемого поля',
            'Delete' => 'Удаление генерируемого поля',
            'Manage' => 'Управление генерируемыми полями',
        );
    }


	public function actionCreate()
	{
		$model = new MailerField;
		
		$form = new BaseForm('mailer.MailerFieldForm', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['MailerField']))
		{
			$model->attributes = $_POST['MailerField'];
			if($model->save())
            {
                $this->redirect(array('manage'));
            }
		}

		$this->render('create', array(
			'form' => $form,
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		$form = new BaseForm('mailer.MailerFieldForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['MailerField']))
		{
			$model->attributes = $_POST['MailerField'];
			if($model->save())
            {
                $this->redirect(array('manage'));
            }
		}

		$this->render('update', array(
			'form' => $form,
		));
	}


	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();

			if(!isset($_GET['ajax']))
            {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
		}
		else
        {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
	}


	public function actionManage()
	{
		$model=new MailerField('search');
		$model->unsetAttributes();
		if(isset($_GET['MailerField']))
        {
            $model->attributes = $_GET['MailerField'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = MailerField::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'mailer-field-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
