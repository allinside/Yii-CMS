<?php
$this->page_title = 'Управление';

$this->tabs = array(
    'добавить' => $this->createUrl('create')
);

$this->widget('application.components.GridView', array(
	'id' => 'doc-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		array('name' => 'user_id', 'value' => '$data->user->name'),
		'title',
		'text',
		'photo',
		'state',
		'date',
		/*
		'date_create',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 

