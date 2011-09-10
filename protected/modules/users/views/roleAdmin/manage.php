<?php
$this->page_title = 'Управление ролями пользователей';

$this->tabs = array(
    "добавить" => $this->createUrl("create"),
);

$this->widget('application.components.GridView', array(
	'id'=>'role-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		'name',
		'description',
		array('name' => 'privileged', 'value' => '$data->privileged ? \'Да\' : \'Нет\''),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
?>
