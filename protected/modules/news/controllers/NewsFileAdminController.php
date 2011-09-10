<?php

class NewsFileAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "Create" => "Добавление файла новости",
            "Update" => "Редактирование файла новости",
            "Delete" => "Удаление файла новости",
            "Manage" => "Управление файлами новостей",    
        );    
    }
    

	public function actionCreate($news_id)
	{	
		$news = $this->loadNewsModel($news_id);
		
		$model = new NewsFile;
		$model->news_id = $news_id;
		
		$form = new BaseForm('news.NewsFileForm', $model);

		if(isset($_POST['NewsFile']))
		{
			$model->attributes = $_POST['NewsFile'];
			if($model->save())
            {
                $this->redirect(array('manage', 'news_id' => $news_id));
            }
		}

		$this->render('create', array(
			'form' => $form,
			'news' => $news
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		$form = new BaseForm('news.NewsFileForm', $model);

		if(isset($_POST['NewsFile']))
		{
			$model->attributes = $_POST['NewsFile'];
			if($model->save())
            {
                $this->redirect(array('manage', 'news_id' => $model->news_id));
            }
		}

		$this->render('update', array(
			'model' => $model,
			'form'  => $form
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
