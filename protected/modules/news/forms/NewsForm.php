<?php

return array(
	'activeForm' => array(
		'id'         => 'news-form',
		'class'      => 'CActiveForm',
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	),
	'elements' => array(
		'title'    => array('type' => 'text', 'class' => 'big'),
		'text'     => array('type' => 'text'),
		'photo'    => array('type' => 'file'),
		'state'    => array('type' => 'dropdownlist', 'items' => News::$states),
		'date'     => array('type' => 'date'),
        'fmanager' => array('type' => 'fmanager')
	),
	'buttons' => array(
		'submit' => array('type' => 'submit', 'value' => $this->model->isNewRecord ? 'Создать' : 'Сохранить')
	)
);
