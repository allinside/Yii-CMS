<?php
$this->page_title = 'Управление блоками страниц';

$this->tabs = array(
    "добавить" => $this->createUrl("create"),
);

$this->widget('application.components.GridView', array(
	'id'=>'page-part-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		'title',
		'name',
		array('name' => 'text', 'type' => 'raw'),
        array('name' => 'lang', 'value' => '$data->language->name'),		
		'date_create',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
?>
