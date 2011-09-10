<?php $this->page_title = 'Управление сообщениями'; ?>

<?php
$this->widget('application.components.GridView', array(
	'id'=>'feedback-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		'first_name',
        'last_name',
        'patronymic',
        'company',
        'position',
        'phone',
		'email',
		'comment',
		'date_create',
		array(
			'class'    => 'CButtonColumn',
			'template' => '{delete}' 
		),
	),
)); 
?>
