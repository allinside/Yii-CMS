<h3><?php echo $news->title; ?></h3>

<?php
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/filesManage.js', CClientScript::POS_END);

$this->page_title = "Файлы новости";

$this->widget('application.components.GridView', array(
	'id'=>'news-files-grid',
	'dataProvider'=>$model->search($news->id),
	'filter'=>$model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		array(
			'name'  => 'file',
			'value' => '"{$data->file} <a href=\'/" . NewsFile::FILES_DIR . $data->file . "\'>открыть</a>";',
			'type'  => 'raw'
 		),
		'created_at',
		array(
			'class'    => 'CButtonColumn',
			'template' => '{delete}'
		),
	),
));

$this->widget('application.extensions.Plupload.Plupload', array(
    'url' => '/news/newsFileAdmin/create/news_id/' . $news->id
));
?>
