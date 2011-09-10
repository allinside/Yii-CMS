<?php
$this->page_title = 'Управление';

$this->tabs = array(
    'добавить язык' => $this->createUrl('create')
);

$this->widget('application.components.GridView', array(
	'id' => 'language-grid',
	'dataProvider' => $model->search(),
	'filter'   => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'  => array(
	    'id',
		'name',
		array(
			'class' => 'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); 

