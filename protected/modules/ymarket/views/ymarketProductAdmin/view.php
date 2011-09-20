<?php
$this->tabs = array(
    'все продукты'  => $this->createUrl('manage')
);

$this->widget('application.components.DetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'brand_id', 'value' => $model->brand->name),
		'name',
		array('name' => 'image', 'value' => $model->getImageHtml(), 'type' => 'raw'),
		'desc_html:raw',
		'date_create',
		'date_update',
	),
)); 


