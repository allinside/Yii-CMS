<?php

$this->tabs = array(
    'управление баннерами' => $this->createUrl('manage'),
    'редактировать' => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('application.components.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'name',
		'url',
		'title',
		'alt',
		'image',
		'is_active',
		'order',
		'date_create',
	),
)); 


