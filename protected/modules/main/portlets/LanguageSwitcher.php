<?php

Yii::import("zii.widgets.CPortlet");

class LanguageSwitcher extends  CPortlet
{
    public function renderContent()
    {
        $langs = Language::model()->findAll(array('order' => "id='ru' DESC"));
        if (count($langs) > 1)
        {
            $this->render('LanguageSwitcher', array('langs' => $langs));
        }
    }
}
