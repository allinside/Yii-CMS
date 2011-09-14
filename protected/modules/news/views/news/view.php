<?php 
$this->page_title = $this->meta_title = $news->title;

if ($news->photo)
{
    $thumb = ImageHelper::thumb(
        News::PHOTOS_DIR,
        $news->photo,
        News::PHOTO_BIG_WIDTH,
        null,
        false
    );
}
?>

<?php if (isset($thumb)): ?>
    <?php echo $thumb; ?>
    <br/>
    <br/>
<?php endif ?>

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





