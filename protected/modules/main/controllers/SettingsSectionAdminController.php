<?php

class SettingsSectionAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create' => 'Добавление раздела настроек',
            'Update' => 'Редактирование раздела настроек',
            'Delete' => 'Удаление раздела настроек',
            'Manage' => 'Управление разделами настроек',
        );
    }
    

	public function actionCreate()
	{
		$model = new SettingsSection;
		
		$form = new BaseForm('main.SettingsSectionForm', $model);

		if(isset($_POST['SettingsSection']))
		{
			$model->attributes = $_POST['SettingsSection'];
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

		$form = new BaseForm('main.SettingsSectionForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['SettingsSection']))
		{
			$model->attributes = $_POST['SettingsSection'];
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
		$model=new SettingsSection('search');
		$model->unsetAttributes();
		if(isset($_GET['SettingsSection']))
        {
            $model->attributes = $_GET['SettingsSection'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = SettingsSection::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'settings-section-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
