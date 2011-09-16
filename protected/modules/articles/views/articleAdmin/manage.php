<?php
$this->page_title = 'Управление материалами';

$this->tabs = array(
    "добавить" => $this->createUrl("create"),
    "управление разделами" => $this->createUrl("articleSectionAdmin/manage"),
);

$this->widget('application.components.GridView', array(
	'id'=>'articles-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		'title',
        array(
            'name'  => 'section_id',
            'value' => '$data->section->name'
        ),
		'date',
        array('name' => 'lang', 'value' => '$data->language->name'),		
		array(
			'name'   => 'files',
			'value'  => '"<a href=\'/articles/articleFileAdmin/manage/article_id/$data->id\'>просмотр</a>";',
			'type'   => 'raw',
			'header' => 'Файлы',
            'filter' => false
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
?>
