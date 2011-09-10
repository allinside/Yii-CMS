<?php
echo '<?php

$this->tabs = array(
    \'управление\'    => $this->createUrl(\'manage\'),
    \'редактировать\' => $this->createUrl(\'update\', array(\'id\' => $model->id))
);';
?>

<?php echo "\n"; ?>$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
<?php
foreach($this->tableSchema->columns as $column)
{
    if ($column->name == 'id')
    {
        continue;
    }

    if ($column->name == 'user_id')
    {
        echo "\t\t" . 'array(\'name\' => \'' . $column->name . '\', \'value\' => $model->user->name),' . "\n";
    }
    else
    {
        echo "\t\t'".$column->name."',\n";
    }
}
?>
	),
)); 


