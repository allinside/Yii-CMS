<?php $this->page_title = 'Восстановление пароля'; ?>

<?php if (isset($error)): ?>
    <?php echo $this->msg($error, 'error'); ?>
<?php endif ?>

<?php echo $form; ?>