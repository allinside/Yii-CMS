<?php

class FmanagerBehavior extends CActiveRecordBehavior
{
    public function afterSave()
    {
        echo "zz";
        die;
    }
}
