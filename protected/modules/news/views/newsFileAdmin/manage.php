<?php $this->page_title = "Файлы новости :: {$news->title}"; ?>

<a href="<?php echo $this->createUrl("create", array("news_id" => $news->id)); ?>">добавить</a>

<?php
$this->widget('application.components.GridView', array(
	'id'=>'news-files-grid',
	'dataProvider'=>$model->search($news->id),
	'filter'=>$model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		'title',
		array(
			'name'  => 'file',
			'value' => '"<a href=\'/" . NewsFile::FILES_DIR . $data->file . "\'>скачать</a>";',
			'type'  => 'raw'
 		),
		'created_at',
		array(
			'class'    => 'CButtonColumn',
			'template' => '{update} {delete}'
		),
	),
)); 
?>
