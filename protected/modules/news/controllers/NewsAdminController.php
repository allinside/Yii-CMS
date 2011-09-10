<?php

class NewsAdminController extends AdminController
{
    public static function actionsTitles() 
    {
        return array(
            "View"   => "Просмотр новости",
            "Create" => "Добавление новости",
            "Update" => "Редактирование новости",
            "Delete" => "Удаление новости",
            "Manage" => "Управление новостями",
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
		$model = new News;
		
		$form = new BaseForm('news.NewsForm', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['News']))
		{
			$model->attributes = $_POST['News'];
			if($model->save())
            {
                $this->redirect(array('view', 'id' => $model->id));
            }
		}
		else 
		{
			$model->date = date("d.m.Y");
		}

		$this->render('create', array(
			'form' => $form,
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		$form = new BaseForm('news.NewsForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['News']))
		{
			$model->attributes = $_POST['News'];
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
		$model=new News('search');
		$model->unsetAttributes();
		if(isset($_GET['News']))
        {
            $model->attributes = $_GET['News'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = News::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
