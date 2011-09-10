<?php

class CityAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "Create" => "Добавление города",
            "Update" => "Редактирование города",
            "Delete" => "Удаление города",
            "Manage" => "Управление городами"
        );
    }


	public static function actionCreate()
	{
		$model = new City;

		$form = new BaseForm('geo.CityForm', $model);
		
		if(isset($_POST['City']))
		{
			$model->attributes = $_POST['City'];
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
		
		$form = new BaseForm('geo.CityForm', $model);
		
		if(isset($_POST['City']))
		{
			$model->attributes = $_POST['City'];
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
		$model=new City('search');
		$model->unsetAttributes();
		if(isset($_GET['City']))
        {
            $model->attributes = $_GET['City'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model=City::model()->findByPk((int) $id);
		if($model===null)
        {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

		return $model;
	}
}
