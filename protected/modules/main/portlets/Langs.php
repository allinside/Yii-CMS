<?php

class Langs extends Portlet
{
    public function renderContent()
    {
        $this->render('Langs', array(
            'langs' => Language::model()->findAll()
        ));
    }
}
