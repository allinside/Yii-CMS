<?php
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/menuTreeView.js');

$this->page_title = $this->page_title . ' :: ' . $menu->name;

$this->tabs = array(
    "управление меню" => "/content/menuAdmin/manage"
);

$this->widget('application.components.TreeView',array(
    'url' => '/content/menuLinkAdmin/AjaxFillTree?menu_id=' . $menu->id,
    'collapsed' => true
));
?>

<a href="<?php echo $this->createUrl('create', array('menu_id' => $menu->id)) ?>" class="bt_green">
	<span class="bt_green_lft"></span>
	<strong>Добавить ссылку</strong>
	<span class="bt_green_r"></span>
</a>
