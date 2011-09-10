<?php


class MailDecoder
{
    public static function decodeSubject($subject)
    {
        //$encoding = self::detectEncoding($subject);
//        $subject = preg_replace("|=\?KOI8-R\?B\?|i", "", $subject);
//        $subject = preg_replace("|=\?koi8-r\?Q\?|i", "", $subject);
//        $subject = preg_replace("|=\?windows-1251\?B|i", "", $subject);
//
//
//        $subject = base64_decode($subject);
//
//        if ($encoding)
//        {
//           $subject = iconv($encoding, "UTF-8", $subject);
//        }

        echo $subject . "\n";
    }


//    private static function detectEncoding($string)
//    {
//        if (preg_match("|KOI8-R|i", $string))
//        {
//            return "KOI8-R";
//        }
//        else if (strpos($string, "windows-1251") !== false)
//        {
//            return "windows-1251";
//        }
//    }
}
