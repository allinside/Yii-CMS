<?php
 
class YmarketTestController extends CController
{
    public function actionIPQueue()
    {
        $ip = YmarketIP::model()->getNext();
    }


    public function actionSectionContent()
    {
        $result = YmarketIP::model()->doRequest("http://market.yandex.ru/guru.xml?CMD=-RR=9,0,0,0-VIS=160-CAT_ID=160043-EXC=1-PG=10&hid=91491");
        echo $result;
    }


    public function actionParseAndUpdateSection()
    {
        $section = YmarketSection::model()->findByPk(1);
        $section->parseAndUpdateAttributes();
    }


    public function actionParseAndUpdateSectionBrands()
    {
        $section = YmarketSection::model()->findByPk(1);
        $section->parseAndUpdateBrands();
    }
}
