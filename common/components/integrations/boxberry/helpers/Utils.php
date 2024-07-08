<?php


namespace common\components\integrations\boxberry\helpers;


class Utils
{
    /**
     * @param $str
     * @return bool
     */
    public static function strToBool($str)
    {
        if ($str === "1") {
            return true;
        } else if ($str === "0") {
            return false;
        }

        $strLowerCase = strtolower($str);
        if ($strLowerCase === "yes") {
            return true;
        } else if ($strLowerCase === "no") {
            return false;
        }

        return (bool)$str;
    }
}