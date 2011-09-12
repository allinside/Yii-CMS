<?php
 
class DateFormatBehavior  extends CActiveRecordBehavior
{
    public function afterFind($event)
    {
        $model = $this->getOwner();

        foreach ($model->attributes as $attr => $value)
        {
            if (preg_match(ActiveRecordModel::PATTERN_MYSQL_DATE_TIME, $value))
            {
                if ($value == "0000-00-00 00:00:00")
                {
                    $model->$attr = null;
                }
                else
                {
                    $model->$attr = Yii::app()->dateFormatter->formatDateTime($value, 'long', 'short');
                }
            }
            elseif (preg_match(ActiveRecordModel::PATTERN_MYSQL_DATE, $value))
            {
                if ($value != "0000-00-00")
                {
                    $model->$attr = Yii::app()->dateFormatter->format('dd.MM.yyyy', $value);
                }
            }
        }
    }


    public function beforeSave()
    {
        $model = $this->getOwner();

        foreach ($model->attributes as $attr => $value)
        {
            if (preg_match(ActiveRecordModel::PATTERN_DATE, $value))
            {
                $model->$attr = date("Y-m-d", strtotime($value));
            }
            elseif (preg_match(ActiveRecordModel::PATTENT_DATE_TIME, $value))
            {
                $model->$attr = date("Y-m-d H:i:c", strtotime($value));
            }
        }
    }
}
