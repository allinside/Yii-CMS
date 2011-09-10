<?php 
$this->page_title = 'Роли'; 

$this->tabs = array(
    "Создать роль" => $this->createUrl("create")
);

function tasksLink($role)
{
	return "<a href='/rbac/TaskAdmin/RolesTasks/role/{$role}'>Задачи</a>";
}

$this->widget('application.components.GridView', array(
	'id' => 'news-grid',
	'dataProvider' => $model->search(AuthItem::TYPE_ROLE),
	'filter'   => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'  => array(
        'name',
        'description',
//        'bizrule',
//        'data',
		array('name' => '&nbsp', 'value' => 'tasksLink($data->name)', 'type' => 'raw'),
		array(
			'class' => 'CButtonColumn',
		),
	),
)); 

