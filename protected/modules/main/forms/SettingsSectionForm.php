<?php

return array(
    'activeForm' => array(
        'id' => 'settings-section-form'
    ),
    'elements' => array(
        'name' => array('type' => 'text'),
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить'
        )
    )
);


