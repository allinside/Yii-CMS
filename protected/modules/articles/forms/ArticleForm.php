<?php

return array(
	'activeForm' => array(
		'id'         => 'article-form',
		'class'      => 'CActiveForm',
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	),
	'elements' => array(
        'section_id' => array(
            'type'  => 'dropdownlist',
            'items' => CHtml::listData(ArticleSection::model()->findAll(), 'id', 'name')
        ),
		'title' => array('type' => 'text'),
		'text'  => array('type' => 'editor'),
		'date'  => array('type' => 'date'),
	),
	'buttons' => array(
		'submit' => array('type' => 'submit', 'value' => $this->model->isNewRecord ? 'Создать' : 'Сохранить')
	)
);
