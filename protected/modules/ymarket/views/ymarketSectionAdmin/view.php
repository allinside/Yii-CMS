<?php

$this->tabs = array(
    'все разделы'   => $this->createUrl('manage'),
    'редактировать' => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('application.components.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'name',
		'yandex_name',
		'url',
		array('name' => 'breadcrumbs', 'value' => strip_tags($model->breadcrumbs)),
		'date_create',
	),
)); 


