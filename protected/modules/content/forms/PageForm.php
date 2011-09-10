<?php

return array(
    'activeForm'=>array(
        'id' => 'page-form',
        'class' => 'CActiveForm',
        'enableAjaxValidation' => false,
        'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => true)
    ),
    'elements' => array(
        'title'            => array('type' => 'text'),
        'meta_title'       => array('type' => 'text'),
        'meta_description' => array('type' => 'text'),
        'meta_keywords'    => array('type' => 'text'),
        'url'              => array('type' => 'text'),
        'text'             => array('type' => 'editor'),
        'is_published'     => array('type' => 'checkbox')
    ),
    'buttons' => array(
        'submit' => array('type' => 'submit', 'value' => 'сохранить')
    )
);

