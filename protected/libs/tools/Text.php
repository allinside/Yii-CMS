<?php

class Text
{
    public static function cut($text, $length, $delim = " ", $tail= "")
    {
        if  (mb_strlen($text, 'utf-8') <= $length) return $text;

        $pos = mb_strpos($text, ' ', $length, 'utf-8');

        if ($pos == false) return $text;

        return mb_substr($text, 0, $pos, 'utf-8') . $tail;
    }


    public static function toUrl($string)
    {
        $string = self::translit($string);
        return  str_replace(" ", "_", $string);
    }


    public static function translit($string)
    {
        $words = array(
            "А" => "A",
            "Б" => "B",
            "В" => "V",
            "Г" => "G",
            "Д" => "D",
            "Е" => "E",
            "Ж" => "J",
            "З" => "Z",
            "И" => "I",
            "Й" => "Y",
            "К" => "K",
            "Л" => "L",
            "М" => "M",
            "Н" => "N",
            "О" => "O",
            "П" => "P",
            "Р" => "R",
            "С" => "S",
            "Т" => "T",
            "У" => "U",
            "Ф" => "F",
            "Х" => "H",
            "Ц" => "TS",
            "Ч" => "CH",
            "Ш" => "SH",
            "Щ" => "SCH",
            "Ъ" => "",
            "Ы" => "YI",
            "Ь" => "",
            "Э" => "E",
            "Ю" => "YU",
            "Я" => "YA",
            "а" => "a",
            "б" => "b",
            "в" => "v",
            "г" => "g",
            "д" => "d",
            "е" => "e",
            "ж" => "j",
            "з" => "z",
            "и" => "i",
            "й" => "y",
            "к" => "k",
            "л" => "l",
            "м" => "m",
            "н" => "n",
            "о" => "o",
            "п" => "p",
            "р" => "r",
            "с" => "s",
            "т" => "t",
            "у" => "u",
            "ф" => "f",
            "х" => "h",
            "ц" => "ts",
            "ч" => "ch",
            "ш" => "sh",
            "щ" => "sch",
            "ъ" => "y",
            "ы" => "yi",
            "ь" => "",
            "э" => "e",
            "ю" => "yu",
            "я" => "ya",
            " " => "_",
            "."  => "",
            ","  => "",
            "?"  => "",
            "!"  => "",
            ":"  => ""
        );
        
        return strtr($string, $words);
    }
}

