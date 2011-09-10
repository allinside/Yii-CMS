<?php
 
class SendLettersCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        MailerLetter::model()->sendLetters();
    }
}
