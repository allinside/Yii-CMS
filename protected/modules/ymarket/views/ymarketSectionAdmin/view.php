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
        'all_models_url',
        'brands_url',
		array('name' => 'breadcrumbs', 'value' => strip_tags($model->breadcrumbs)),
		'date_create',
        'date_update',
        'date_brand_update',
        'date_pages_parse',
        array(
            'name' => 'Бренды',
            'value' => $model->brands ? implode('<br/> ', ArrayHelper::extract($model->brands, 'name')) : null,
            'type' => 'raw'
        ),
	),
)); 


