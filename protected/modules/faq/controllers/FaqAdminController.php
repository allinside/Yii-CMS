<?php

class FaqAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "View"   => "Просмотр вопроса",
            "Create" => "Добавление вопроса",
            "Update" => "Редактирование вопроса",
            "Delete" => "Удаление вопроса",
            "Manage" => "Управление вопросами"
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
		$model = new Faq;

		$form = new BaseForm('faq.FaqForm', $model);
		
		$this->performAjaxValidation($model);

		if(isset($_POST['Faq']))
		{
			$model->attributes = $_POST['Faq'];
			if($model->save())
            {
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

		$form = new BaseForm('faq.FaqForm', $model);
		
		$this->performAjaxValidation($model);

		if(isset($_POST['Faq']))
		{
			$model->attributes = $_POST['Faq'];
			if($model->save())
            {
                $this->redirect(array('view', 'id'=>$model->id));
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
		$model=new Faq('search');
		$model->unsetAttributes();
		if(isset($_GET['Faq']))
        {
            $model->attributes = $_GET['Faq'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model=Faq::model()->findByPk((int) $id);
		if($model===null)
        {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'faq-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
