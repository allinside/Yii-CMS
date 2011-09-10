<?php

class BottomMenu extends Portlet
{
    const MENU_ID = 7;

    public function renderContent()
    {
        $this->render('BottomMenu', array(
			'sections' => Menu::model()->findByPk(self::MENU_ID)->getSections()
		));
    }
}
