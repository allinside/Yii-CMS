<?php

$this->page_title = $model->title;

$this->tabs = array(
    "список страниц"    => $this->createUrl('manage'),
	"добавить страницу" => $this->createUrl('create'),
    "редактировать"     => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('application.components.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'title',
		array('name' => 'lang', 'value' => $model->language->name),        
		'meta_title',
		'meta_description',
		'meta_keywords',
		'url',
		array(
            'name'  => 'is_published',
            'value' => $model->is_published ? "да" : "нет"
        ),
		'date_create',
		array(
            'name'  => 'text',
            'type'  => 'raw',
            'value' => $model->text
        ),
	),
));
?>
