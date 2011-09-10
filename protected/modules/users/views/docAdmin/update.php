<?php
$this->page_title = 'Редактирование';

$this->tabs = array(
    'управление' => $this->createUrl('manage'),
    'просмотр'   => $this->createUrl('view', array('id' => $form->model->id))
);

echo $form;