<?php
$this->page_title = "Редактирование файла новости :: {$model->news->title}";

$this->tabs = array(
    "управление файлами" => $this->createUrl("manage", array("news_id" => $model->news->id)),
);

echo $form;
?>