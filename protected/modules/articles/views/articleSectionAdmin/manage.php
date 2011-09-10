<?php
$this->page_title = 'Управление разделами';

$this->tabs = array(
    "добавить" => $this->createUrl("create"),
    "управление материалами" => $this->createUrl("articleAdmin/manage"),
);

$this->widget('application.components.GridView', array(
	'id'=>'article-section-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		'name',
		array('name' => 'parent_id', 'value' => '$data->parent ? $data->parent->name : null'),
		array('name' => 'in_sidebar', 'value' => '$data->in_sidebar ? "Да" : "Нет"'),
		'date_create',
        array('name' => 'lang', 'value' => '$data->language->name'),		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
?>
