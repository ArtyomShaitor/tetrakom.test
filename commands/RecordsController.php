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
        for ($i = 0; $i < $recordsCount; $i++) {
            $record = new Record();
            $record->phone_a = RecordMaster::generateNumber();
            $record->phone_b = RecordMaster::generateNumber();

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