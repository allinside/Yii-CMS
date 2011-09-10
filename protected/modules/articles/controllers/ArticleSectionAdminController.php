<?php

class ArticleSectionAdminController extends AdminController
{
    public static function actionsTitles() 
    {
        return array(
            "View" => "Просмотр раздела",
            "Create" => "Добавление раздела",
            "Update" => "Редактирование раздела",
            "Delete" => "Удаление раздела",
            "Manage" => "Управление разделами",
            "GetSectionInSidebar" => "Получить раздел, который в сайдбаре",
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
		$model = new ArticleSection;
		
		$form = new BaseForm('articles.ArticleSectionForm', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['ArticleSection']))
		{
			$model->attributes = $_POST['ArticleSection'];
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

		$form = new BaseForm('articles.ArticleSectionForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['ArticleSection']))
		{
			$model->attributes = $_POST['ArticleSection'];
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
		$model=new ArticleSection('search');
		$model->unsetAttributes();
		if(isset($_GET['ArticleSection']))
        {
            $model->attributes = $_GET['ArticleSection'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = ArticleSection::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'article-section-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	public function actionGetSectionInSidebar() 
	{
	    $section = ArticleSection::model()->findByAttributes(array(
	        'in_sidebar' => 1
	    ));
	    
	    echo CJSON::encode($section);
	}
}
