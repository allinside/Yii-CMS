<?php

$elements = array(
    'template_id' => array(
        'type'  => 'dropdownlist',
        'items' => CHtml::listData(MailerTemplate::model()->findAll(), 'id', 'name'),
        'prompt' => 'не выбран'
    ),
    'subject'   => array('type' => 'text'),
    'text'      => array('type' => 'editor'),
    'users_ids' => array('type' => 'widget', 'widget' => 'UsersCheckboxes')
);

if ($this->model->scenario == 'with_template' || $this->model->template)
{
    unset($elements['subject']);
    unset($elements['text']);
}

return array(
    'activeForm' => array(
        'id' => 'mailer-letter-form',
		'enableAjaxValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
			'validateOnChange' => true
		)
    ),
    'elements' => $elements,
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить')
    )
);


