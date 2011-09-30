<?php

$this->tabs = array(
    'добавить баннер' => $this->createUrl('create')
);

$this->widget('application.components.GridView', array(
	'id' => 'banner-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'name',
		'url',
		'title',
		'alt',
		'image',
		'is_active',
		'date_create',
		array(
			'class' => 'CButtonColumn',
		),
	),
)); 

