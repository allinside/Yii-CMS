<?php
function getRecipientsList($model)
{
    if (!$model->users)
    {
        return;
    }

    $list = "";

    $model->users = array_slice($model->users, 0 ,5);
    foreach ($model->users as $user)
    {
        $list.= $user->name . "<br/>";
    }

    $list.= "<a href='/mailer/mailerRecipientAdmin/manage/letter_id/{$model->id}'>подробнее</a>";

    return $list;
}


function getStatistics($model)
{
    $statistics = array();
        
    foreach (MailerRecipient::$statuses as $status => $title)
    {
        $statistics[] = $title . ': ' . count($model->recipients(array('condition' => "status = '{$status}'")));
    }

    return implode("<br/>", $statistics);
}

$this->tabs = array(
    'создать рассылку' => $this->createUrl('create')
);

$this->widget('application.components.GridView', array(
	'id' => 'mailer-letter-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
        'date_create',
		array('name' => 'subject', 'value' => '$data->template ? $data->template->subject : $data->subject'),
        array('name' => 'text', 'value' => '$data->template ? $data->template->getTextContent(true) : $data->getTextContent(true)', 'type' => 'raw'),
		array('name' => 'template_id', 'value' => '$data->template ? $data->template->name : null'),
		array('name' => 'Список рассылки', 'value' => 'getRecipientsList($data)', 'type' => 'raw'),
        array('name' => 'Статистика', 'value' => 'getStatistics($data)', 'type' => 'raw'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 

