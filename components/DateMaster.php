<?php
/**
 * Created by PhpStorm.
 * User: artyom
 * Date: 23.08.16
 * Time: 18:26
 */

namespace app\components;


class DateMaster
{
    public static function toDefaultDateFormat($timestamp)
    {
        date_default_timezone_set("Europe/Kiev");
        return date("Y-m-d H:i:s", $timestamp);
    }
}