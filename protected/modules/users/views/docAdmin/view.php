<?php
$this->page_title = 'Просмотр ';

$this->tabs = array(
    'управление'    => $this->createUrl('manage'),
    'редактировать' => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'user_id', 'value' => $model->user->name),
		'title',
		'text',
		'photo',
		'state',
		'date',
		'date_create',
	),
)); 


