<?php

class MailerLetterAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create' => 'Cоздание рассылки',
            'Update' => 'Редактирование рассылки',
            'View'   => 'Отчет об отправке',
            'Manage' => 'Отчеты о рассылках',
            'Delete' => 'Удаление рассылки'
        );
    }
    

	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionCreate($template_id = null)
	{
        $scenario = 'without_template';

        if ($template_id)
        {
            $scenario = 'with_template';
        }
  
		$model = new MailerLetter($scenario);
		$model->template_id = $template_id;

		$form = new BaseForm('mailer.MailerLetterForm', $model);
		
	    $this->performAjaxValidation($model);

		if(isset($_POST['MailerLetter']))
		{   
			$model->attributes = $_POST['MailerLetter'];
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


	public function actionUpdate($id, $template_id = null)
	{
		$model = $this->loadModel($id);

        if (!is_null($template_id) && empty($template_id))
        {
            $model->template_id = null;
            $model->scenario = 'without_template';
        }

		$form = new BaseForm('mailer.MailerLetterForm', $model);

		$this->performAjaxValidation($model);

		if(isset($_POST['MailerLetter']))
		{
			$model->attributes = $_POST['MailerLetter'];
			if($model->save())
            {
                $model->updateRecipients(isset($_POST['users_ids']) ? $_POST['users_ids'] : array());

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
		$model=new MailerLetter('search');
		$model->unsetAttributes();
		if(isset($_GET['MailerLetter']))
        {
            $model->attributes = $_GET['MailerLetter'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = MailerLetter::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'mailer-letter-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
