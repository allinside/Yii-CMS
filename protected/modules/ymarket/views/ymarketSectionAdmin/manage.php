<?php

$this->tabs = array(
    'добавить' => $this->createUrl('create')
);

$this->widget('application.components.GridView', array(
	'id' => 'ymarket-section-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		'name',
		'yandex_name',
		'url',
		'breadcrumbs',
		'date_create',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 

