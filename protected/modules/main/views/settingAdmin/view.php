<?php
$this->page_title = 'Просмотр настройки';

$this->tabs['Редактировать'] = $this->createUrl('update', array('id' => $model->id));

$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
        'title',
		'const',
        array('label' => 'Значение', 'value' => $model->value, 'type' => 'raw')
	),
));
?>