<?php

class ActionFileAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "Create" => "Добавление файла мероприятия",
            "Delete" => "Удаление файла мероприятия",
            "Manage" => "Управление файлами мероприятий"
        );    
    }


	public function actionCreate($action_id)
	{
        if ($_FILES)
        {
            $file_path = $_SERVER['DOCUMENT_ROOT'] . ActionFile::FILES_DIR . $_FILES['file']['name'];
            if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path))
            {
                $action_file = new ActionFile;
                $action_file->action_id = $action_id;
                $action_file->file = $_FILES['file']['name'];
                if ($action_file->save())
                {

                }
                else
                {
                    file_put_contents('errors.txt', $action_file->errorsHtml());
                }

                chmod($file_path, 0777);
            }
        }
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


	public function actionManage($action_id)
	{
        $action = $this->loadActionModel($action_id);

		$model=new ActionFile('search');
		$model->unsetAttributes();
		if(isset($_GET['ActionFile']))
        {
            $model->attributes = $_GET['ActionFile'];
        }

		$this->render('manage', array(
			'model'  => $model,
            'action' => $action
		));
	}


	public function loadModel($id)
	{
		$model = ActionFile::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'action-file-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


    public function loadActionModel($action_id)
    {
        $model = Action::model()->findByPk($action_id);
        if ($model === null)
        {
            $this->pageNotFound();
        }

        return $model;
    }
}
