<?php
$this->page_title = 'Добавление новости';

$this->tabs = array(
    "управление новостями" => $this->createUrl("manage")
);

echo $form;
?>