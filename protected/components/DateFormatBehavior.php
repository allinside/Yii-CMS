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
                if ($value != "0000-00-00 00:00:00")
                {
                    $model->$attr = Yii::app()->dateFormatter->formatDateTime($value, 'long', 'short');
                }
            }
            elseif (preg_match(ActiveRecordModel::PATTERN_MYSQL_DATE, $value))
            {
                if ($value != "0000-00-00")
                {
                    $model->$attr = Yii::app()->dateFormatter->format('dd MMMM yyyy', $value);
                }
            }
        }
    }
}
