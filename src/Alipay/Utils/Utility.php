<?php


namespace Alipay\Utils;


class Utility
{
    public static function currentTime($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }

    public static function randomNumber($length = 10)
    {
        $start = 1;
        $end   = 9;
        for ($i = 0; $i < $length; $i++) {
            $start *= 10;
            $end = $end * 10 + $end;
        }

        return mt_rand($start, $end);
    }


    public static function checkEmpty($value)
    {
        if (!isset($value)) {
            return true;
        }
        if ($value === null) {
            return true;
        }
        if (trim($value) === "") {
            return true;
        }

        return false;
    }
}