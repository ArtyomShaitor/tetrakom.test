<?php
/**
 * Created by PhpStorm.
 * User: artyom
 * Date: 23.08.16
 * Time: 17:51
 */

namespace app\commands;

use app\components\DateMaster;
use app\components\RecordMaster;
use app\models\Record;
use yii\console\Controller;

class RecordsController extends Controller
{
    public function actionGenerate($recordsCount = 10000)
    {
        $array = [];
        for ($i = 0; $i < 100; $i++) {
            $array[] = RecordMaster::generateNumber();
        }
        for ($i = 0; $i < $recordsCount; $i++) {
            $record = new Record();
            $record->phone_a = (string)$array[rand(0, count($array)-1)];
            $record->phone_b = (string)$array[rand(0, count($array)-1)];

            $begin_date = RecordMaster::generateDate();
            $connection_date = RecordMaster::getConnectionDate($begin_date);
            $finish_date = RecordMaster::getFinishDate($connection_date);

            $record->begin_date = DateMaster::toDefaultDateFormat($begin_date);
            $record->connection_date = DateMaster::toDefaultDateFormat($connection_date);
            $record->finish_date = DateMaster::toDefaultDateFormat($finish_date);
            $record->direction = RecordMaster::getDirection();
            echo $record->save()? "record with id={$record->id} is created".PHP_EOL : "error".PHP_EOL;
        }
    }

}