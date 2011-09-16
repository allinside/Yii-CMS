<?php
function getValue($value)
{
    $max_length = 50;

    if (mb_strlen($value, 'utf-8') > $max_length)
    {
        $value = mb_substr($value, 0, $max_length, "utf-8") . '...';
    }

    return $value;
}

$this->widget('application.components.GridView', array(
	'id' => 'settings-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
        array('name' => 'module', 'value' => '$data->module'),
		'title',
        array('name' => 'value', 'value' => 'getValue($data->value)', 'type' => 'raw'),
		array(
			'class'=>'CButtonColumn',
			'template' => '{view}{update}'
		),
	),
));

