<?php

$this->tabs = array(
    'все разделы'   => $this->createUrl('manage'),
    'редактировать' => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		'name',
		'yandex_name',
		'url',
		'breadcrumbs',
		'date_create',
	),
)); 


