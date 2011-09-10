<?php
$this->page_title = "Просмотр Пользователя: {$model->name}";

$this->tabs = array(
    "управление пользователями" => $this->createUrl("manage"),
    "редактировать" => $this->createUrl("update", array("id" => $model->id))
);

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'last_name',
        'first_name',
        'patronymic',
		'email',
		'company',
		'birthdate',
		array(
			'name'  => 'city_id',
			'value' => $model->city->name
		),
		array(
			'name'  => 'club_status', 
			'value' => User::$club_status_list[$model->club_status]
		),
		'phone',
		'fax',
        'company',
        'position',
		array(
			'name'  => 'role',
			'value' => $model->role->description
		),
		array(
			'name'  => 'gender',
			'value' => $model->gender == "man" ? "муж." : "жен."
		),
		array(
			'name'  => 'status',
			'value' => User::$status_list[$model->status]
		),
		array(
			'name'  => 'date_create',
			'value' => Dater::humanDateTime($model->date_create)
		),
	),
));
?>
