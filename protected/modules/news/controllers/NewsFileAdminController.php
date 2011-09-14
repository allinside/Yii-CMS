<?php

class NewsFileAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "Create" => "Добавление файла новости",
            "Delete" => "Удаление файла новости",
            "Manage" => "Управление файлами новостей",    
        );    
    }
    

	public function actionCreate($news_id)
	{	
        if ($_FILES)
        {
            $file_path = $_SERVER['DOCUMENT_ROOT'] . NewsFile::FILES_DIR . $_FILES['file']['name'];
            if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path))
            {
                $news_file = new NewsFile;
                $news_file->news_id = $news_id;
                $news_file->file = $_FILES['file']['name'];
                $news_file->save();

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


	public function actionManage($news_id)
	{
        $news = $this->loadNewsModel($news_id);

		$model=new NewsFile('search');
		$model->unsetAttributes();
		if(isset($_GET['NewsFile']))
        {
            $model->attributes = $_GET['NewsFile'];
        }

		$this->render('manage', array(
			'model' => $model,
			'news'  => $news
 		));
	}


	public function loadModel($id)
	{
		$model = NewsFile::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


    public function loadNewsModel($news_id)
    {
		$news = News::model()->findByPk($news_id);
		if (!$news)
		{
			$this->pageNotFound();
		}

        return $news;
    }
}
