<?php

class ForeignKeyNullValueBehavior extends CActiveRecordBehavior
{
    public function beforeSave()
    {
        $model = $this->getOwner();

        $foreign_keys = $model->tableSchema->foreignKeys;

        foreach ($model->attributes as $name => $value)
        {
            if (array_key_exists($name, $foreign_keys) && $model->metadata->columns[$name]->allowNull && trim($value) == '')
            {
                $model->$name = null;
            }
        }
    }
}
