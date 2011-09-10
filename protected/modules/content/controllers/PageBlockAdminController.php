<?php

class PageBlockAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "View"   => "Просмотр контентного блока",
            "Create" => "Добавление контентного блока",
            "Update" => "Редактирование контентного блока",
            "Delete" => "Удаление контентного блока",
            "Manage" => "Управление контентными блоками"    
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
		$model = new PageBlock;
		
		$form = new BaseForm('content.PageBlockForm', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['PageBlock']))
		{
			$model->attributes = $_POST['PageBlock'];
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

		$form = new BaseForm('content.PageBlockForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['PageBlock']))
		{
			$model->attributes = $_POST['PageBlock'];
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
		$model=new PageBlock('search');
		$model->unsetAttributes();
		
		if(isset($_GET['PageBlock']))
        {
            $model->attributes = $_GET['PageBlock'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = PageBlock::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'page-part-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
