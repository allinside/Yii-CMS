<?php
$this->page_title = "Добавление файла новости :: {$news['title']}";

$this->tabs = array(
    "управление файлами" => $this->createUrl("manage", array("news_id" => $form->model->news->id)),
);

echo $form;
?>
