<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artos
 * Date: 13.09.11
 * Time: 22:45
 * To change this template use File | Settings | File Templates.
 */
 
class ArrayHelper
{
    public function extract($array_of_arrays, $key)
    {
        $result = array();

        foreach ($array_of_arrays as $array)
        {
            if (is_object($array))
            {
                if (isset($array->$key))
                {
                    $result[] = $array->$key;
                }
            }
            elseif (is_array($array))
            {
                if (array_key_exists($key, $array))
                {
                    $result[] = $array[$key];
                }
            }
        }

        return $result;
    }
}
