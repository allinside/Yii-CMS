<?php

Yii::import('zii.widgets.CPortlet');

class Portlet extends CPortlet 
{
    public function url($route, $params = array(), $ampersand = '&')
    {
        return Yii::app()->controller->url($route, $params = array(), $ampersand = '&');
    }


    public function getModule()
    {
        return Yii::app()->getModule(Yii::app()->controller->module->name);
    }
}
