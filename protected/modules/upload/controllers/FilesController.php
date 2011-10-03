<?php
class FilesController extends AdminController
{
    public $layout = '//layouts/main';

    /**
     * @static
     * @return array
     */
    public static function actionsTitles()
    {
        return array(
            "UpdateAttr" => "Инлайн-редактирование",
            "Upload" => "Отображение брендов",
            "SavePriority" => "Сортировка",
            "Delete" => "Удаление файла",
            "ExistFiles" => "Существующие файлы",
            "SetWatermark" => "Наложить изображение"
        );
    }

    public function actionSetWatermark()
    {
        $model = $this->loadModel();
        if ($model->setWatermark($_GET['position'])) {
            $this->sendFilesAsJson(array($model));
        } else {
            echo CHtml::tag('div', array(), $model->error);
        }

    }

    public function actionExistFiles()
    {
        $existFiles = Files::model()->parent($_GET['typeParent'], $_GET['idParent'])->tag($_GET['tag'])->findAll();
        $this->sendFilesAsJson($existFiles);
    }
    
    /**
     * @param $name
     * @return void
     */
    public function actionUpload()
    {
        //save file
        $model = new Files('insert');
        $model->idParent = $_GET['idParent'];
        $model->typeParent = $_GET['typeParent'];
        $model->tag = $_GET['tag'];

//        if (!empty($_FILES['file']['tmp_name'])) {
//            $this->sendFilesAsJson($model, array('error' => 'maxFileSize'));
//        }

        $options = isset($_GET['options']) ? $_GET['options'] : array();
        $newName = $model->getUniqueName(Files::UPLOAD_PATH, 'file');
        $func = 'save'.ucfirst($_GET['dataType']).'OnServer';
        if ($model->$func('file', $newName, $options)) {
            if ($model->save())
                $this->sendFilesAsJson(array($model));
            else
                echo $model->error;
        } else {
            echo json_encode(array(
                'textStatus' => $model->error
            ));
        }
    }

    private function sendFilesAsJson($files)
    {
        $res = array();
        foreach ((array)$files as $file) {
            $res[] = array(
                'name'          => $file->title,
                'size'          => $file->size,
                'url'           => $file->src,
                'thumbnail_url' => $file->src,
                'delete_url'    => $file->deleteUrl,
                'delete_type'   => "GET",
                'edit_link'     => UploadHtml::editableLink('Редактировать', $file, 'title', 'files/updateAttr', array('class'=>'thumb-edit')),
                'has_watermark' => (int)$file->has_watermark,
                'id'            => 'File_'.$file->id
            );
        }
        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        echo  CJSON::encode($res);
    }
    
    /**
     * @todo generally action must work with 2 parameters: from and to, and update only records between them at one query, but then we must use draggable and droppable on client instead of sortable. maybe later
     * @return void
     */
    public function actionSavePriority()
    {
        $i = 0;
        $success = false;
        $ids = array_reverse($_POST['File']);
        $files = new Files('sort');
        $transaction = $files->dbConnection->beginTransaction();
        try {
            foreach($ids as $id) {
                $i++;
                $success = $files->updateAll(array('order'=>$i), 'id='.$id) || $success;
            }
            if (!$success)
                throw new CException('Some error ☺');

            $transaction->commit();
        } catch(Exception $e) {
            $transaction->rollBack();
        }
    }

    /**
     * @return void
     */
    public function actionDelete()
    {
        $model = $this->loadModel()->delete();
    }

    public function actionUpdateAttr()
    {
        $model = $this->loadModel();
        
        $model->scenario = 'update';

        $this->performAjaxValidation($model);

        if (isset($_POST[get_class($model)])){
            $attr = $_GET['attr'];
            $model->$attr = $_POST[get_class($model)][$attr];
            
            if ($model->save()) {
                echo $model->$_GET['attr'];
            }
        }
    }

    public function loadModel()
    {

        if(isset($_GET['id'])) {
            $condition = '';
//            if(Yii::app()->user->isGuest)
//                $condition = 'status='.Season::STATUS_PUBLISHED.' OR status='.Season::STATUS_ARCHIVED;
            $model = Files::model()->findByPk($_GET['id'], $condition);
        }
        if($model === null)
            throw new CHttpException(404,'The requested page does not exist.');
		return $model;
    }

    /**
     * @param CModel the model to be validated
     */
    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax'])){
            print_r(CActiveForm::validate($model));
            Yii::app()->end();
        }
    }
    
}