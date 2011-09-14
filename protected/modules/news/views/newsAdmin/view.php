<?php
$this->page_title = 'Просмотр новости';

$this->tabs = array(
    "управление новостями" => $this->createUrl('manage'),
    "редактировать"        => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('application.components.DetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'title'),
		array('name' => 'lang', 'value' => $model->language->name),
		array(
		'name'  => 'user_id', 
		'value' => $model->user->name
		),
		array(
			'name'  => 'photo', 
			'value' => ImageHelper::thumb(News::PHOTOS_DIR, $model->photo, News::PHOTO_SMALL_WIDTH), 
			'type'  => 'raw'
		),
		array(
			'name'  => 'state', 
			'value' => News::$states[$model->state]
		),
		'date',
		'date_create',
		array(
			'name' => 'text', 
			'type' => 'raw'
		)
	),
)); 
?>
