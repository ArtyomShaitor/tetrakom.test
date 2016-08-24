<?php

use app\models\Record;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
/**
 * @var $this yii\web\View
 * @var $model Record
 * @var $searchModel app\models\RecordSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $callsCount integer
 * @var $incomingCallsCount integer
 * @var $outgoingCallsCount integer
 * @var $maxCallLength integer
 * @var $avgCallLength integer
 * @var $oftenUsedPhoneB string
 */

$this->title = 'Statistics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php ActiveForm::begin(); ?>
    <?php
        echo DateRangePicker::widget([
            'model'=>$model,
            'attribute'=>'begin_date',
            'convertFormat'=>true,
            'pluginOptions'=>[
                'locale'=>['format' => 'Y-m-d'],
            ]
        ]);
    ?>
    <?php ActiveForm::end();?>

    <h3>Period: <?=$date_from." - ".$date_to;?></h3>
    <table class="table table-striped table-bordered detail-view">
        <tr>
            <td>Calls count</td>
            <td><?=$callsCount?></td>
        </tr>
        <tr>
            <td>Incoming calls count</td>
            <td><?=$incomingCallsCount?></td>
        </tr>
        <tr>
            <td>Outgoing calls count</td>
            <td><?=$outgoingCallsCount?></td>
        </tr>
        <tr>
            <td>Max call length</td>
            <td><?=$maxCallLength?></td>
        </tr>
        <tr>
            <td>Average call length</td>
            <td><?="~".$avgCallLength?></td>
        </tr>
        <tr>
            <td>Often used phone B</td>
            <td><?=$oftenUsedPhoneB?></td>
        </tr>
    </table>
</div>
<?php
    $this->registerJs("$(\"#record-begin_date\").change(function(){
        $(\"#w0\").submit();
    })");
?>
