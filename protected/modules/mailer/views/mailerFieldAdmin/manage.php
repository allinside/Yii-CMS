<?php
$this->page_title = 'Управление генерируемыми полями';

$this->tabs = array(
    'добавить поле' => $this->createUrl('create')
);

$this->widget('application.components.GridView', array(
	'id' => 'mailer-field-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		'code',
		'name',
		'value',
		array(
			'class'=>'CButtonColumn',
            'template' => '{update} {delete}'
		),
	),
)); 

