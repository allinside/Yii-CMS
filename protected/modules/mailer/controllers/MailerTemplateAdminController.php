<?php

class MailerTemplateAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create' => 'Добавление шаблона рассылки',
        	'View'   => 'Просмотр шаблона рассылки',
        	'Update' => 'Редактирование шаблона рассылки',
        	'Manage' => 'Управление шаблонами рассылки',
            'Delete' => 'Удаление шаблона рассылки'
        );
    }

    
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionCreate()
	{
		$model = new MailerTemplate;
		
		$form = new BaseForm('mailer.MailerTemplateForm', $model);
		
		$this->performAjaxValidation($model);

		if(isset($_POST['MailerTemplate']))
		{	
			$model->attributes = $_POST['MailerTemplate'];
			if($model->save())
            {	
            	if (isset($_POST['users_ids'])) 
            	{	
            		$model->addRecipients($_POST['users_ids']);
            	}
            	
                $this->redirect(array('view', 'id' => $model->id));
            }
		}

		$this->render('create', array(
			'form' => $form,
		));
	}
	
	
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		
		$form = new BaseForm('mailer.MailerTemplateForm', $model);

		$this->performAjaxValidation($model);

		if(isset($_POST['MailerTemplate']))
		{
			$model->attributes = $_POST['MailerTemplate'];
			if($model->save())
            {	            	
            	$model->deleteRecipients();
            	
            	if (isset($_POST['users_ids'])) 
            	{
					$model->addRecipients($_POST['users_ids']);
            	}
     
                $this->redirect(array('view', 'id' => $model->id));
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
		$model=new MailerTemplate('search');
		$model->unsetAttributes();
		if(isset($_GET['MailerTemplate']))
        {
            $model->attributes = $_GET['MailerTemplate'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = MailerTemplate::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'mailer-template-form')
		{   
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
