<a name="feedback"></a>

<?php if ($done): ?>
    <?php echo $this->controller->msg('Сообщение успешно отправлено!', 'ok'); ?>
<?php else: ?>
    <?php $this->controller->renderPartial('application.views.layouts._siteForm', array('form' => $form)); ?>
<?php endif ?>


