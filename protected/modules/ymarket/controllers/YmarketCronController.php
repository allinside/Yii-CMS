<?php
 
class YmarketCronController extends CController
{
    public function actionPerformTasks()
    {
        $model = YmarketCron::model();
        $crons = $model->findAll('is_active = 1', array('order' => 'priority'));
        foreach ($crons as $cron)
        {
            $elapsed_secs= time() - strtotime($cron->date_of);
            if ($elapsed_secs < $cron->interval)
            {
                continue;
            }

            $model->{$cron->method}();

            $cron->date_of = new CDbExpression('NOW()');
            $cron->save();
        }
    }


//    public function actionIPQueue()
//    {
//        $ip = YmarketIP::model()->getNext();
//    }
//
//
//    public function actionSectionContent()
//    {
//        $result = YmarketIP::model()->doRequest("http://market.yandex.ru/guru.xml?CMD=-RR=9,0,0,0-VIS=160-CAT_ID=160043-EXC=1-PG=10&hid=91491");
//        echo $result;
//    }


//    public function actionParseAndUpdateSection()
//    {
//        $section = YmarketSection::model()->findByPk(1);
//        $section->parseAndUpdateAttributes();
//    }


//    public function actionParseAndUpdateSectionBrands()
//    {
//        $section = YmarketSection::model()->findByPk(1);
//        $section->parseAndUpdateBrands();
//    }


//    public function actionParsePages()
//    {
//        YmarketPage::model()->parse();
//    }


//    public function actionParseProducts()
//    {
//        YmarketProduct::model()->parse();
//    }
}
