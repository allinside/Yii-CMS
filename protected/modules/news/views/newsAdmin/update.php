<?php
$this->page_title = 'Редактирование новости';

$this->tabs = array(
    "управление новостями" => $this->createUrl("manage")
);

echo $form;

$this->widget('upload.portlets.Uploader', array(
    'model' => $form->model,
    'id' => 'uploader',
    'dataType' => 'any',
    'maxFileSize' => 10*1000*1000,
    'tag' => 'files'
));


