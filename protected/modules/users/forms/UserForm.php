<?php

$roles = AuthItem::model()->findAllByAttributes(array('type' => AuthItem::TYPE_ROLE));

return array(
    'activeForm'=>array(
        'id' => 'user-form',
        'class' => 'CActiveForm'
    ),
    'elements'       => array(
        'email'      => array('type' => 'text'),
		'first_name' => array('type' => 'text'),
        'last_name'  => array('type' => 'text'),
        'patronymic' => array('type' => 'text'),
    	'company'    => array('type' => 'text'),
        'position'   => array('type' => 'text'),
    	'phone'      => array('type' => 'text'),
    	'fax'        => array('type' => 'text'),
    	'city_id' => array(
    		'type'  => 'dropdownlist',
    		'items' => CHtml::listData(City::model()->findAll(), 'id', 'name'),
    	),
        'birthdate'  => array('type' => 'date'),
        'gender' => array(
        	'type'  => 'dropdownlist', 
        	'items' => User::$gender_list
    	),
        'status' => array(
        	'type'  => 'dropdownlist', 
        	'items' => User::$status_list
    	),
        'club_status' => array(
        	'type'  => 'dropdownlist', 
        	'items' => User::$club_status_list
    	),    	   	
        'role' => array(
        	'type'  => 'dropdownlist',
        	'items' => CHtml::listData($roles, 'name', 'description')
    	),
        'password'   => array('type' => 'password'),
        'password_c' => array('type' => 'password')
    ),
    'buttons' => array(
        'submit' => array('type' => 'submit', 'value' => 'сохранить')
    )
);


