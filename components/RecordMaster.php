<?php

namespace app\components;
use app\models\Record;


class RecordMaster
{
    private static $codes = [39, 44, 50, 63, 66, 67, 68, 91, 92, 93, 94, 95, 96, 97];
    
    public static function getDirection()
    {
        $calls = [Record::INCOMING_CALL, Record::OUTGOING_CALL];
        return rand(0, count($calls)-1);
    }

    /**
     * Генерирует телефонный номер
     * @return string
     */
    public static function generateNumber()
    {
        $code = self::$codes[rand(0, count(self::$codes)-1)];
        return "380{$code}".rand(1000000, 9999999);
    }

    /**
     * Генерирует случайную дату от 01.01.2016
     * @return int
     */
    public static function generateDate()
    {
        $now = time();
        $start = strtotime("1 January 2016");
        return rand($start, $now);
    }

    /**
     * Генерирует случайное время соединения на основе данной даты
     * @param $timestamp
     * @return int
     */
    public static function getConnectionDate($timestamp)
    {
        $fromNow = "+".rand(10, 60)." seconds";
        return strtotime($fromNow, $timestamp);
    }

    /**
     * Генерирует случайное время разъединения на основе данной даты
     * @param $timestamp
     * @return int
     */
    public static function getFinishDate($timestamp)
    {
        $fromNow = "+".rand(30, 1800)." seconds";
        return strtotime($fromNow, $timestamp);
    }
}