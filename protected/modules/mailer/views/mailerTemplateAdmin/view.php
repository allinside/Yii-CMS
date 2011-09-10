<?php
$this->tabs = array(
    'управление шаблонами' => $this->createUrl('manage'),
    'редактировать'        => $this->createUrl('update', array('id' => $model->id))
);


$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		'name',
		'subject',
		array('name' => 'is_basic', 'value' => $model->is_basic ? "Да" : "Нет"),
		'date_create',
		array('name' => 'text', 'type' => 'raw'),
        array('name' => 'Подписчики', 'value' => $this->widget('Recipients', array('users' => $model->users), 1), 'type' => 'raw')
	),
));
?>






