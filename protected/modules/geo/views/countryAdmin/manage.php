<?php
$this->page_title = "Управление странами";

$this->tabs = array(
    "добавить" => $this->createUrl("create"),
);

$this->widget('application.components.GridView', array(
	'id'=>'country-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		'name',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update} {delete}'
		),
	),
)); 
?>
