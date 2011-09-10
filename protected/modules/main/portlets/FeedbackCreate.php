<?php

Yii::import('zii.widgets.CPortlet');

class FeedbackCreate extends CPortlet 
{
    public function renderContent() 
    {
        $model = new Feedback;
        $form  = new BaseForm('main.FeedbackForm', $model);

        if(isset($_POST['ajax']) && $_POST['ajax'] == 'feedback-form')
        {	
             echo CActiveForm::validate($model);
             Yii::app()->end();
        }

        if (isset($_POST['Feedback']))
        {
            $model->attributes = $_POST['Feedback'];
            if ($model->save())
            {
                $done = true;
            }
        }    
    
        $this->render("FeedbackCreate", array(
            'form' => $form, 
            'done' => isset($done)
        ));
    }
}
