<?php $this->page_title = 'Авторизация'; ?>

<?php if (isset($auth_error)): ?>
    <?php echo $this->msg($auth_error, 'error'); ?>
<?php endif ?>

<?php echo $form; ?>

