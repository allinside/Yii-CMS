<?php 
$this->page_title = $news->title;
?>

<br clear="all"/>

<?php echo ImageHelper::thumb(News::PHOTOS_DIR, $news->photo, News::PHOTO_BIG_WIDTH, null, false, "border='0' class='detail_img'"); ?>

<?php echo $news->content; ?>

<br clear='all' />

<?php if ($news->files): ?>
	<div style="margin-top:30px;margin-bottom:10px;font-weight:bold">
            <?php echo Yii::t('NewsModule.main', 'Файлы для скачивания') ?>:
        </div>

	<?php foreach ($news->files as $file): ?>
		<a href='/<?php echo NewsFile::FILES_DIR . "/" . $file->file ?>' class='link_13'><?php echo $file->title ?></a> <br/>
	<?php endforeach ?>
<?php endif ?>


<div style="margin-top:30px;font-weight:bold"><?php echo Yii::t('NewsModule.main', 'Смотрите также') ?>:</div>

<?php $this->renderPartial('_list', array('news_list' => $news_list)); ?>




