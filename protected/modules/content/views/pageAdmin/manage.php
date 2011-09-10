<?php
$this->page_title = 'Страницы сайта';

$this->tabs = array(
    "добавить страницу" => $this->createUrl('create')
);

$this->widget('application.components.GridView', array(
	'id' => 'page-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
    'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		array(
			'name' => 'title',
			'type' => 'raw'
		),
		'url',
		array(
			'name'  => 'is_published',
			'value' => '$data->is_published ? "Да" : "Нет"'
		),
        array('name' => 'lang', 'value' => '$data->language->name'),		
		array(
			'class'=>'CButtonColumn',
		),
	),
));
?>

