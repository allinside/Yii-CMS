<?php

$this->tabs = array(
    'добавить группу' => $this->createUrl('create')
);

$this->widget('application.components.GridView', array(
	'id' => 'certificate-group-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		'name',
        array('name' => 'date_create', 'filter' => false),
		array(
			'class'    => 'CButtonColumn',
            'template' => '{update} {delete}'
		),
	),
)); 

