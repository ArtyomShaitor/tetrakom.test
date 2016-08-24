<?php

use app\models\Record;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="/js/notify.min.js"></script>
<div class="record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>
    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'phone_a',
            'phone_b',
            [
                'attribute' => 'begin_date',
                'filterType'=> \kartik\grid\GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions'=>[
                    'pluginOptions'=>[
                        'allowClear'=>true,
                        'locale'=>['format' => 'YYYY-MM-DD'],
                    ],

                ],
            ],
            [
                'attribute' => 'direction',
                'value' => function($model) {
                    return $model->direction == Record::INCOMING_CALL? "Incomming" : "Outgoing";
                },
                'filter' => [
                    Record::INCOMING_CALL => "Incoming",
                    Record::OUTGOING_CALL => "Outgoing"
                ],
            ],
            [
                'attribute' => 'comment',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::activeTextarea($model, 'comment', [
                        'class' => 'form-control comment',
                        'data-id' => $model->id
                    ]);
                },
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>

<script>
    $(document).on('change', "textarea.comment", function(){
        var id = $(this).data("id");
        var comment = $(this).val();
        var xhr = new XMLHttpRequest();
        var fd = new FormData();

        fd.append('Record[id]', id);
        fd.append('Record[comment]', comment);
        fd.append("_csrf", yii.getCsrfToken());

        xhr.onload = function()
        {
            var response = JSON.parse(xhr.response);
            if(response.result == true)
                $.notify("The comment was saved!", "success");
            else
                $.notify("Something went wrong", "error");
        };
        xhr.open('POST', '/record/savecomment');
        xhr.send(fd);
    });
</script>
