<?php

$this->widget('application.components.GridView', array(
	'id' => 'site-action-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		'title',
		array('name' => 'user_id', 'value' => '$data->user ? $data->user->name : null'),
		'object_id',
		'module',
		'controller',
		'action',
		'date_create',
		array(
			'class'=>'CButtonColumn',
			'template' => ''
		),
	),
)); 

