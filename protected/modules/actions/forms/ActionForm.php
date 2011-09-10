<?php

return array(
    'activeForm' => array(
        'id' => 'action-form',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
    ),
    'elements' => array(
        'name'  => array('type' => 'textarea'),
        'place' => array('type' => 'textarea'),
        'desc'  => array('type' => 'editor'),
        'image' => array('type' => 'file'),
        'date'  => array('type' => 'date'),
    ),
    'buttons' => array(
        'submit' => array('type' => 'submit', 'value' => $this->model->isNewRecord ? 'Создать' : 'Сохранить')
    ) 
);
