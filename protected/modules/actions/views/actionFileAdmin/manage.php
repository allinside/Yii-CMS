<h3><?php echo $action->name; ?></h3>

<?php
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/manage.js', CClientScript::POS_END);

$this->page_title = "Файлы события";

$this->tabs = array(
    "добавить" => $this->createUrl('create', array('action_id' => $action->id))
);

$this->widget('application.components.GridView', array(
	'id'=>'action-file-grid',
	'dataProvider'=>$model->search($action->id),
	'filter'=>$model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		array(
			'name'  => 'file',
			'value' => '"{$data->file} <a href=\'/" . ActionFile::FILES_DIR . $data->file . "\'>открыть</a>";',
			'type'  => 'raw'
 		),
		'created_at',
		array(
			'class'=>'CButtonColumn',
            'template' => '{delete}'
		),
	),
));

$this->widget('application.extensions.Plupload.Plupload', array(
    'url' => '/actions/actionFileAdmin/create/action_id/' . $action->id
));
?>
