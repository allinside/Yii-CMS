<?php
$this->page_title = 'Управление пользователями';

$this->tabs = array(
    "добавить" => $this->createUrl("create"),
);

$this->widget('application.components.GridView', array(
	'id' => 'user-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
    	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		'last_name',
        'first_name',
        'patronymic',
		'email',
//		'birthdate',
//		array(
//			'name'  => 'gender',
//			'value' => 'User::$gender_list[$data->gender]'
//		),
		array(
			'name'  => 'status', 
			'value' => 'User::$status_list[$data->status]'
		),
		array(
			'name'  => 'club_status', 
			'value' => 'User::$club_status_list[$data->club_status]'
		),
//		'phone',
        'company',
        'position',
		array(
			'name'  => 'role',
			'value' => 'isset($data->role->description) ? $data->role->description : null'
		),
		'date_create',
		array(
			'class' => 'CButtonColumn',
		),
	),
));
?>

