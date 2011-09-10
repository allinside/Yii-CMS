<?php $this->page_title = 'Просмотр ';?>

<?php 
$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'user_id',
		'title',
		'text',
		'photo',
		'state',
		'date',
		'date_create',
	),
)); 
?>

