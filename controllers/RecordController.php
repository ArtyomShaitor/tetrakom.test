<?php

namespace app\controllers;

use app\components\DateMaster;
use Yii;
use app\models\Record;
use app\models\RecordSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecordController implements the CRUD actions for Record model.
 */
class RecordController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    public function actionSavecomment()
    {
        $result = [];
        if (isset($_POST['Record'])) {
            $model = Record::findOne($_POST['Record']['id']);
            if ($model !== null) {
                $model->comment = $_POST['Record']['comment'];
                if ($model->save()) {
                    $result['result'] = true;
                    return json_encode($result);
                }
            }
        }
        $result['result'] = false;
        return json_encode($result);
    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatistics()
    {
        $model = new Record();
        if (isset($_POST['Record'])) {
//            $model->begin_date = $_POST['Record']['begin_date'];
            $date_explode = explode(" - ", $_POST['Record']['begin_date']);
            $date_to = trim($date_explode[1]);
            $date_from = trim($date_explode[0]);

        } else {
            $now = time();
            $date_to = DateMaster::toDefaultDateFormat($now);
            $date_from = DateMaster::toDefaultDateFormat(strtotime("1 January 2016"));
        }

        $dateCondition = ['between', 'begin_date', $date_from, $date_to];

        $callsCount = Record::find()
            ->filterWhere($dateCondition)
            ->count();

        $incomingCallsCount = Record::find()
            ->filterWhere($dateCondition)
            ->andWhere("direction=:d", [":d" => Record::INCOMING_CALL])
            ->count();

        $outgoingCallsCount = $callsCount - $incomingCallsCount;

        $maxCallLength = Record::find()
            ->select(['phone_a', 'phone_b', 'MAX( TIMESTAMPDIFF( SECOND ,  `connection_date` ,  `finish_date` ) ) AS callLength'])
            ->filterWhere($dateCondition)
            ->one();
        $maxCallLength = DateMaster::toDefaultTimeFormat($maxCallLength->callLength);

        $avgCallLength = Record::find()
            ->select(['phone_a', 'phone_b', 'AVG( TIMESTAMPDIFF( SECOND ,  `connection_date` ,  `finish_date` ) ) AS callLength'])
            ->filterWhere($dateCondition)
            ->one();
        $avgCallLength = DateMaster::toDefaultTimeFormat($avgCallLength->callLength);

        $oftenUsedPhoneB = Record::find()
            ->select(["phone_b", "COUNT(*) AS count"])
            ->groupBy(['phone_b'])
            ->filterWhere($dateCondition)
            ->one();

        return $this->render('statistics', [
            "model" => $model,
            "callsCount" => $callsCount,
            "incomingCallsCount" => $incomingCallsCount,
            "outgoingCallsCount" => $outgoingCallsCount,
            "maxCallLength" => $maxCallLength,
            "avgCallLength" => $avgCallLength,
            "oftenUsedPhoneB" => isset($oftenUsedPhoneB->phone_b)? $oftenUsedPhoneB->phone_b : null,
            "date_from" => substr($date_from, 0, 10),
            "date_to" => substr($date_to, 0, 10),
        ]);
    }

    /**
     * Displays a single Record model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Record model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Record();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Record model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Record model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Record model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Record the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Record::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
