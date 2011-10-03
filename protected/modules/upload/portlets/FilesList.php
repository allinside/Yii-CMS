<?php
class FilesList extends Portlet
{
    public $items;

    private $assets;
    
    public function init()
    {
        parent::init();
        $this->registerScripts();
    }

    public function registerScripts()
    {
        $this->assets = Yii::app()->getModule('upload')->assetsUrl();

        Yii::app()->clientScript
            ->registerCssFile($this->assets.'/css/filesList.css');
    }

    public function renderContent()
    {
        $this->render('filesList');
    }
}