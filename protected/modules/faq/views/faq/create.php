<?php $this->page_title = Yii::t('FaqModule.main', 'Добавление вопроса'); ?>

<?php if ($done): ?>
    <?php echo $this->msg(Yii::t('FaqModule.main', 'Ваш вопрос успешно добавлен'), 'ok'); ?>
<?php endif ?>

<?php echo $this->renderPartial("application.views.layouts._siteForm", array('form' => $form)); ?>
