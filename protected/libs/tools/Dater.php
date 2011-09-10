<?php

class Dater
{
    private static function prepareDate($date = null)
    {
        if (is_null($date))
        {
            $date = time();
        }
        else
        {
            $date = strtotime($date);
        }

        return $date;
    }


    private static function formatDate($date, $format)
    {
        $date = self::prepareDate($date);
        return date($format, $date);
    }


    public static function humanDate($date = null)
    {
        if ($date == "0000-00-00" || !$date) return;

        return self::formatDate($date, 'd.m.Y');
    }


    public static function humanDateTime($date = null)
    {
        return self::formatDate($date, 'd.m.Y H:i:s');
    }


    public static function mysqlDate($date = null)
    {
        return self::formatDate($date, 'Y-m-d');
    }


    public static function mysqlDateTime($date = null)
    {
        return self::formatDate($date, 'Y-m-d H:i:s');
    }


    public static function isCurrentDate($date)
    {
        $date = strtotime(date("Y-m-d", strtotime($date)));

        $current_date = strtotime(date("Y-m-d", time())) == $date;

        return $current_date;
    }


    public static function humanRussianDate($date = null, $year = false)
    {
        if ($date == "0000-00-00 00:00:00") return false;

        $locale = new Zend_Locale('ru');

        $template = $year ? "dd MMMM YYYY" : "dd MMMM";

        if (!$date)
        {
            $date = time();
        }
        else
        {
            $date = strtotime($date);

            if (date("Y") != date("Y", $date) && !$year)
            {
                $template.= " Y";    
            }
        }

        $date = new Zend_Date($date, false, $locale);

        return $date->toString($template);
    }


    public static function humanRussianDateTime($date = null, $year = false)
    {
        if ($date == "0000-00-00 00:00:00") return false;

        $locale = new Zend_Locale('ru');

        $template = "d MMMM";

        if (!$date)
        {
            $date = time();
        }
        else
        {
            $date = strtotime($date);

            if (date("Y") != date("Y", $date))
            {
                $template.= " Y";
            }            
        }

        $date = new Zend_Date($date, false, $locale);

        $template.= " HH:m";

        return $date->toString($template);
    }


    public static function monthRuName($number)
    {
        $months = self::months();
        $number = (int) $number;

        if (isset($months[$number])) return $months[$number];
    }


    public static function months()
    {
        return array(
            "1"  => "январь",
            "2"  => "февраль",
            "3"  => "март",
            "4"  => "апрель",
            "5"  => "май",
            "6"  => "июнь",
            "7"  => "июль",
            "8"  => "август",
            "9"  => "сентябрь",
            "10" => "октябрь",
            "11" => "ноябрь",
            "12" => "декабрь"
        );
    }
}

