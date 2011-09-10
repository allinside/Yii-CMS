<?php $this->page_title = $page->title; ?>

<?php echo $page->content ?>

<?php if ($page->id == 7 || $page->id == 18): ?>
    <div class="search_result"><?php echo Yii::t('main', 'Подать заявку на вступление в члены Клуба'); ?></div>
    <?php $this->widget('FeedbackCreate'); ?>
<?php endif; ?>



