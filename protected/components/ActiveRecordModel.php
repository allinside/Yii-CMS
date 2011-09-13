<?php

class ActiveRecordModel extends CActiveRecord
{
    const PATTERN_DATE = '#^(\d\d?)\.(\d\d?)\.(\d\d\d\d)$#';

    const PATTENT_DATE_TIME = '#^(\d\d?)\.(\d\d?)\.(\d\d\d\d) (\d\d)\:(\d\d):(\d\d)$#';

    const PATTERN_MYSQL_DATE = '#^(\d\d\d\d)-(\d\d?)-(\d\d?)$#';

    const PATTERN_MYSQL_DATE_TIME = '#^(\d\d\d\d)-(\d\d?)-(\d\d?) (\d\d)\:(\d\d):(\d\d)$#';

    const PATTERN_LAT_ALPHA = '/^[A-Za-z]+$/ui';
    
    const PATTERN_PHONE = '/^\+[1-9]-[0-9]+-[0-9]{7}$/';

    const PATTERN_RULAT_ALPHA = '/^[а-яa-z]+$/ui';

    const PATTERN_RULAT_ALPHA_SPACES = '/^[а-яa-z ]+$/ui';


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function behaviors()
    {   
        return array(
            'DateFormat' => array(
                'class' => 'application.components.activeRecordBehaviors.DateFormatBehavior'
            ),
            'LangCondition' => array(
                'class' => 'application.components.activeRecordBehaviors.LangConditionBehavior'
            ),
            'NullValue' => array(
                'class' => 'application.components.activeRecordBehaviors.NullValueBehavior'
            ),
            'UserForeignKey' => array(
                'class' => 'application.components.activeRecordBehaviors.UserForeignKeyBehavior'
            ),
            'UploadFile' => array(
                'class' => 'application.components.activeRecordBehaviors.UploadFileBehavior'
            )
        );
    }


    public function attributeLabels()
    {
        $meta = $this->meta();

        $labels = array();

        foreach ($meta as $field_data)
        {
            $labels[$field_data["Field"]] = Yii::t('main', $field_data["Comment"]);
        }

        return $labels;
    }


    /*VALIDATORS________________________________________________________________________________*/
    public function humanDate($attr, $date)
    {
        if (!empty($this->$attr))
        {
            if (!preg_match(self::PATTERN_DATE, $this->$attr))
            {
                $this->addError($attr, Yii::t('main', 'Используейте календарь!'));
            }
        }
    }


    public function phone($attr)
    {
        if (!empty($this->$attr))
        {
            if (!preg_match(self::PATTERN_PHONE, $this->$attr))
            {
                $this->addError($attr, Yii::t('main', 'Неверный формат! Пример: +7-903-5492969'));
            }
        }
    }
	
    
    public function latAlpha($attr)
    {
        if (!empty($this->$attr))
        {
            if (!preg_match(self::PATTERN_LAT_ALPHA, $this->$attr))
            {
                $this->addError($attr, Yii::t('main', 'только латинский алфавит'));
            }
        }    
    }
    
	
    public function ruLatAlpha($attr)
    {
        if (!empty($this->$attr))
        {
            if (!preg_match(self::PATTERN_RULAT_ALPHA, $this->$attr))
            {
                $this->addError($attr, Yii::t('main', 'только русский или латинский алфавит'));
            }
        }
    }


    public function ruLatAlphaSpaces($attr)
    {
        if (!empty($this->$attr))
        {
            if (!preg_match(self::PATTERN_RULAT_ALPHA_SPACES, $this->$attr))
            {
                $this->addError($attr, Yii::t('main', 'только русский или латинский алфавит с учетом пробелов'));
            }
        }
    }
    /*___________________________________________________________________________________*/
    

    /*SCOPES___________________________________________________________________________________*/
    public function scopes()
    {
        return array(
           'published' => array('condition' => 'is_published = 1'),
           'ordered'   => array('order' => '`order`'),
           'last'      => array('order' => 'date_create DESC')
        );
    }


	public function limit($num)
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'limit' => $num,
	    ));

	    return $this;
	}


	public function notEqual($param, $value)
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'condition' => "`{$param}` != '{$value}'",
	    ));

	    return $this;
	}
    /*___________________________________________________________________________________*/


    public function meta()
    {
        $meta = Yii::app()->db
                          ->cache(1000)
                          ->createCommand("SHOW FUll columns FROM " . $this->tableName())
                          ->queryAll();
        
        foreach ($meta as $ind => $field_data)
        {
            $meta[$field_data["Field"]] = $field_data;
            unset($meta[$ind]);
        }
      
        return $meta;
    }

    
    public function changeOrder($id, $order)
    {
        $sql = "SELECT COUNT(id) AS count_ids
                       FROM " . $this->tableName() . "
                       GROUP BY `order` HAVING count_ids > 1";

        $need_fix_table = Yii::app()->db->createCommand($sql)->execute();
        if ($need_fix_table)
        {
            $sorted_objects = array();

            $objects = $this->findAll(array('order' => '`order`'));
            foreach ($objects as $ind => $object)
            {
                $object->order = $ind;
                $object->save();
            }
        }

        $object = $this->findByPk($id);
        if (!$object)
        {
            return;
        }

        $criteria = new CDbCriteria();
        $criteria->addCondition('id != ' . $object->id);

        if ($object->parent_id)
        {
            $criteria->addCondition('parent_id = ' . $object->parent_id);
        }
        else
        {
            $criteria->addCondition('parent_id IS NULL');
        }

        if ($order == 'up')
        {
            $criteria->addCondition('`order` < ' . $object->order);
            $criteria->order = '`order` DESC';
        }
        else
        {
            $criteria->addCondition('`order` > ' . $object->order);
            $criteria->order = '`order`';
        }

        $neighbor_object = $this->find($criteria);

        if (!$neighbor_object)
        {
            return;
        }

        $object_order = $object->order;

        $object->order = $neighbor_object->order;
        $object->save(false);

        $neighbor_object->order = $object_order;
        $neighbor_object->save(false);

        return true;
    }


    public function optionsTree($name = 'name', $id = null, $result = array(), $value = 'id', $spaces = 0, $parent_id = null)
    {
        $objects = $this->findAllByAttributes(array(
            'parent_id' => $parent_id
        ));

        foreach ($objects as $object)
        {
            if ($object->id == $id) continue;

            $result[$object->$value] = str_repeat("_", $spaces) . $object->$name;

            if ($object->childs)
            {
                $spaces+=2;

                $result = $this->optionsTree($name, $id, $result, $value, $spaces, $object->id);
            }
        }

        return $result;
    }
}
