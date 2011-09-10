<?php

$form = include "UserForm.php";

$form['elements'] = array(
    'email'    => $form['elements']['email'],
    'password' => $form['elements']['password']
);

return $form;