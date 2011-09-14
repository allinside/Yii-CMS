<?php

class DateFormatBehavior extends CActiveRecordBehavior
{
    const DB_DATE_TIME_FORMAT = 'Y-m-d h:i:c';
    const DB_DATE_FORMAT      = 'Y-m-d';


    public function beforeSave()
    {
        if (get_class($this->getOwner()) != 'News')
        {
            return false;
        }

        $model = $this->getOwner();

        $columns = $this->getOwner()->metaData->columns;
        foreach ($columns as $i => $column)
        {
            if ($column->dbType == 'date')
            {
                $attr = $column->name;
                $model->$attr = date(self::DB_DATE_FORMAT, strtotime($model->$attr));
            }
            else if (in_array($column->dbType, array('timestamp', 'datetime')))
            {
                $attr = $column->name;
                $model->$attr = date(self::DB_DATE_TIME_FORMAT, strtotime($model->$attr));
            }
        }
    }
}
