<?php
 
class TestController extends CController
{
    public function actionSendMail()
    {
        MailerModule::sendMail("artem@avim.ru", "Mailer Тест", "Все пиздато");
    }
}
