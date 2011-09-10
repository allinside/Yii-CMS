<?php

if (!$this->model->date_publish) 
{
	$this->model->date_publish = Yii::app()->dateFormatter->format('dd.MM.y', time());	
}

return array(
	'activeForm' => array(
		'id' => 'document-form'
	),
	'elements' => array(
		'name'         => array('type' => 'text'),
		'desc'         => array('type' => 'editor'),
		'date_publish' => array('type' => 'date'),
		'is_published' => array('type' => 'checkbox')
	),
	'buttons' => array(
		'submit' => array('type' => 'submit', 'value' => $this->model->isNewRecord ? 'Добавить' : 'Сохранить')
	)
);
