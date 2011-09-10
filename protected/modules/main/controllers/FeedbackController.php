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
        $this->render('create');
    }
}
