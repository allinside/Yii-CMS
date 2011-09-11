<?php

class FeedbackController extends BaseController
{   
    public static function actionsTitles() 
    {
        return array(
            "Create" => "Добавление сообщения"
        );
    }
    

    public function actionCreate()
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
                $form->clear();
                $done = true;
            }
        }

        $this->render("create", array(
            'form' => $form,
            'done' => isset($done)
        ));
    }
}
