<?php

class DocumentAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "View"   => "Просмотр документа",
            "Create" => "Добавление документа",
            "Update" => "Редактирование документа",
            "Delete" => "Удаление документа",
            "Manage" => "Управление документами",
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
		$model = new Document;
		
		$form = new BaseForm('documents.DocumentForm', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['Document']))
		{
			$model->attributes = $_POST['Document'];
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

		$form = new BaseForm('documents.DocumentForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['Document']))
		{
			$model->attributes = $_POST['Document'];
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
		$model=new Document('search');
		$model->unsetAttributes();
		if(isset($_GET['Document']))
        {
            $model->attributes = $_GET['Document'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = Document::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'document-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
