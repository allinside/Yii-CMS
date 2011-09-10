<?php
$form = include "UserForm.php";

$form['activeForm']['enableAjaxValidation'] = false;

unset($form['elements']['gender']);
unset($form['elements']['status']);
unset($form['elements']['role']);

return $form;
