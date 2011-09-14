<?php
$this->page_title = 'Управление новостями';

$this->tabs = array(
    "добавить новость" => $this->createUrl("create")
);

$this->widget('application.components.GridView', array(
	'id'=>'news-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		'title',
		array(
		    'name'  => 'user_id', 
		    'value' => '$data->user->name'
		),
		array(
		    'name'  => 'photo', 
		    'value' => 'ImageHelper::thumb(News::PHOTOS_DIR, $data->photo, News::PHOTO_SMALL_WIDTH);',
			'type'  => 'raw'
		),
		array('name' => 'state', 'value' => 'News::$states[$data->state]'),
		'date',
		array(
			'name'   => 'files', 
			'value'  => '"
						<a href=\'/news/newsFileAdmin/manage/news_id/$data->id\'>просмотр</a>
						";', 
			'type'   => 'raw',
			'header' => 'Файлы'
		),
        'date_create',
        array('name' => 'lang', 'value' => '$data->language->name'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
?>
