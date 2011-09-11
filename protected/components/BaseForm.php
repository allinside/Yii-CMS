<?php
 
class BaseForm extends CForm
{
    public $model;

    private $_clear = false;

    
    public function __construct($path, $model)
    {
        $this->model = $model;

        list($module, $form) = explode(".", $path, 2);
        parent::__construct("application.modules.{$module}.forms.{$form}", $model);
    }


    public function __ToString()
    {
        $tpl =  mb_substr(Yii::app()->controller->id, -5) == 'Admin' ? '_adminForm' : '_form';

    	try
    	{
            if ($this->_clear)
            {
                Yii::app()->clientScript->registerScript(
                    'clearForm',
                    '$(function()
                    {
                        $(":input","#' . $this->activeForm['id'] . '")
                            .not(":button, :submit, :reset, :hidden")
                            .val("")
                            .removeAttr("checked")
                            .removeAttr("selected");
                    })'
                );
            }

	        return Yii::app()->controller->renderPartial(
	            'application.views.layouts.' . $tpl,
	            array('form' => $this),
	            true
	        );  		
    	}
		catch (CException $e)
		{
			echo $e->getMessage();
			return "";
		}
    }


    public function clear()
    {
        $this->_clear = true;
    }
}
