<?php

class BannerAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр баннера',
            'Create' => 'Создание баннера',
            'Update' => 'Редактирование баннера',
            'Delete' => 'Удаление баннера',
            'Manage' => 'Управление баннерами',
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
		$model = new Banner;
		
		$form = new BaseForm('banners.BannerForm', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['Banner']))
		{
			$model->attributes = $_POST['Banner'];
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

		$form = new BaseForm('banners.BannerForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['Banner']))
		{
			$model->attributes = $_POST['Banner'];
			if($model->save())
            {
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
		$model=new Banner('search');
		$model->unsetAttributes();
		if(isset($_GET['Banner']))
        {
            $model->attributes = $_GET['Banner'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = Banner::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'banner-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
