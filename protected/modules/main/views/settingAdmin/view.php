<?php
$this->page_title = 'Просмотр настройки';

$this->tabs['Редактировать'] = $this->createUrl('update', array('id' => $model->id));

$this->widget('application.components.DetailView', array(
	'data' => $model,
	'attributes' => array(
        'title',
		'code',
        array('label' => 'Значение', 'value' => $model->value, 'type' => 'raw')
	),
));
?>
