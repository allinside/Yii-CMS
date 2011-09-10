<?php $this->page_title = 'Авторизация'; ?>

<?php if (isset($error)): ?>
    <div class='error_box'>
        <?php echo $error ?>
    </div>
<?php endif ?>

<?php if (isset($msg)): ?>
    <div class='valid_box'><?php echo $msg ?></div>
<?php endif ?>

<?php $form; ?>

