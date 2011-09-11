<?php $this->page_title = Yii::t('MainModule.main', 'Обратная связь'); ?>

<?php if (isset($done) && $done): ?>
    <?php echo $this->msg('Сообщение успешно отправлено!', 'ok'); ?>
<?php endif ?>

<?php echo $form; ?>





