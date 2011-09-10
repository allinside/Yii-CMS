<?php
$this->page_title = 'Настройки';
if ($section)
{
    $this->page_title.= ' :: ' . $section;
}


function getValue($value)
{
    $max_length = 50;

    if (mb_strlen($value, 'utf-8') > $max_length)
    {
        $value = mb_substr($value, 0, $max_length, "utf-8") . '...';
    }

    return $value;
}
?>



<?php
$this->widget('application.components.GridView', array(
	'id' => 'settings-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
        array('name' => 'section', 'value' => '$data->section->name', 'sortable' => true),
		'title',
        array('name' => 'value', 'value' => 'getValue($data->value)'),
		array(
			'class'=>'CButtonColumn',
			'template' => '{view}{update}'
		),
	),
));
?>
