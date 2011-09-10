<?php

$this->tabs = array(
    'управление шаблонами рассылки' => $this->createUrl('manage')
);

$this->renderPartial(
	            'application.views.layouts._form',
	            array('form' => $form));