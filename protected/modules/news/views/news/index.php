<?php 
$this->page_title = Yii::t('NewsModule.main', 'Новости');

$this->renderPartial('_list', array('news_list' => $news_list));

$this->renderPartial('application.views.layouts.pagination', array('pages' => $pages));
?>
