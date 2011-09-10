<?php 
$this->page_title = 'Задачи'; 

$this->tabs = array(
    "Добавить задачу" => $this->createUrl("create")
);

$this->widget('application.components.GridView', array(
	'id' => 'task-grid',
	'dataProvider' => $model->search(AuthItem::TYPE_TASK),
	'filter'       => $model,
	'template'     => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
        'name',
        'description',
        array('name' => 'allow_for_all', 'value' => '$data->allow_for_all ? "Да" : "Нет"'),
		array(
			'class' => 'CButtonColumn',
		),
	),
)); 

