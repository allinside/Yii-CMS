<?php

$this->widget('application.components.GridView', array(
	'id' => 'mailer-option-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		'name',
		'value',
		array(
			'class' => 'CButtonColumn',
			'template' => '{update}'
		),
	),
)); 

