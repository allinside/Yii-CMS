<?php
 
class MenuAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "Create" => "Добавление меню",
            "Update" => "Редактирование меню",
            "Manage" => "Управление меню",
            "Delete" => "Удаление меню",
        );    
    }


    public function actionCreate()
    {
        $model = new Menu;

        $form = new BaseForm('content.MenuForm', $model);

        if (isset($_POST['Menu']))
        {
            $model->attributes = $_POST['Menu'];
            if ($model->validate())
            {
                $model->save(false);
                $this->redirect('/content/menuLinkAdmin/index/menu_id/' . $model->id);
            }
        }

        $this->render('create', array('form' => $form));
    }
    
    
    public function actionUpdate($id) 
    {
    	$model = $this->loadModel($id);   	
    	
    	$form = new BaseForm('content.MenuForm', $model);
    	
    	if (isset($_POST['Menu'])) 
    	{
    		$model->attributes = $_POST['Menu'];
    		if ($model->save()) 
    		{
    			$this->redirect($this->createUrl('manage'));
    		}
    	}
    	
    	$this->render('update', array('form' => $form));
    }


    public function actionManage()
    {
        $model = new Menu();

        $this->render('manage', array('model' => $model));
    }


    public function actionDelete($id)
    {
		$model = $this->loadModel($id)->delete();  
					
		$this->redirect($this->createUrl('manage'));
    }


    private function loadModel($id)
    {
        $model = Menu::model()->findByPk((int) $id);
        if ($model === null)
        {
            $this->pageNotFound();
        }

        return $model;
    }
}
