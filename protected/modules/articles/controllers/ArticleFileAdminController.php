<?php

class ArticleFileAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "Create" => "Добавление файла",
            "Delete" => "Удаление файла",
            "Manage" => "Управление файлами",
        );
    }


	public function actionCreate($article_id)
	{	
        if ($_FILES)
        {
            $file_path = $_SERVER['DOCUMENT_ROOT'] . ArticleFile::FILES_DIR . $_FILES['file']['name'];
            if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path))
            {
                $article_file = new ArticleFile;
                $article_file->article_id = $article_id;
                $article_file->file = $_FILES['file']['name'];
                $article_file->save();
           
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


	public function actionManage($article_id)
	{   
        $article = $this->loadArticleModel($article_id);

		$model=new ArticleFile('search');
		$model->unsetAttributes();
		if(isset($_GET['ArticleFile']))
        {
            $model->attributes = $_GET['ArticleFile'];
        }

		$this->render('manage', array(
			'model'   => $model,
			'article' => $article
 		));
	}


	public function loadModel($id)
	{
		$model = ArticleFile::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


    public function loadArticleModel($article_id)
    {
		$articles = Article::model()->findByPk($article_id);
		if (!$articles)
		{
			$this->pageNotFound();
		}

        return $articles;
    }
}
