<?php

$this->tabs = array(
    'добавить' => $this->createUrl('create')
);

$this->widget('application.components.GridView', array(
	'id' => 'ymarket-product-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		array('name' => 'brand_id', 'value' => '$data->brand->name'),
		'name',
		array('name' => 'image', 'value' => '$data->getImageHtml(true)', 'type' => 'raw'),
		'date_create',
		'date_update',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 

