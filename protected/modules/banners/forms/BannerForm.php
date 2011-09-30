<?php

return array(
    'activeForm' => array(
        'id' => 'banner-form',
		//'enableAjaxValidation' => true,
		//'clientOptions' => array(
		//	'validateOnSubmit' => true,
		//	'validateOnChange' => true
		//)
    ),
    'elements' => array(
        'name'      => array('type' => 'text'),
        'url'       => array('type' => 'text'),
        'title'     => array('type' => 'text'),
        'alt'       => array('type' => 'text'),
        'image'     => array('type' => 'file'),
        'is_active' => array('type' => 'checkbox'),
        'order'     => array('type' => 'text'),

    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить')
    )
);


