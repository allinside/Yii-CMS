<?php 
$this->page_title = 'Роли'; 

$this->tabs = array(
    "Создать роль" => $this->createUrl("create")
);

function tasksLink($role)
{
	return "<a href='/rbac/TaskAdmin/RolesTasks/role/{$role}'>Задачи</a>";
}

$not_system_role = '!in_array($data->name, AuthItem::$system_roles)';

$this->widget('application.components.GridView', array(
	'id' => 'news-grid',
	'dataProvider' => $model->search(AuthItem::TYPE_ROLE),
	'filter'   => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'  => array(
        'name',
        'description',
		array('name' => '&nbsp', 'value' => 'tasksLink($data->name)', 'type' => 'raw'),
		array(
			'class' => 'CButtonColumn',
            'buttons' => array(
                'update' => array(
                    'visible' => $not_system_role
                ),
                'delete' => array(
                    'visible' => $not_system_role
                )
            )
		),
	),
)); 

