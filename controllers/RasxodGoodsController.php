<?php

namespace app\controllers;

use app\models\CurrencyRates;
use app\models\PrixodGoods;
use app\models\RasxodGoods;
use app\models\search\RasxodGoodsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RasxodGoodsController implements the CRUD actions for RasxodGoods model.
 */
class RasxodGoodsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all RasxodGoods models.
     *
     * @return string
     */
//    public function actionIndex()
//    {
//        $searchModel = new RasxodGoodsSearch();
//        $dataProvider = $searchModel->search($this->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Displays a single RasxodGoods model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new RasxodGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
//    public function actionCreate()
//    {
//        $model = new RasxodGoods();
//
//        if ($this->request->isPost) {
//            if ($model->load($this->request->post()) && $model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Updates an existing RasxodGoods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->cost_usd = CurrencyRates::getSummaUsd($model->rasxod->date, $model->cost, $model->currency_id);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка сохранения данных'));
            }
            return $this->redirect(['rasxod/goods-list', 'rasxod_id' => $model->rasxod_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RasxodGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $rasxod_id = $model->rasxod_id;

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно удалены'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка удаления данных'));
        }

        return $this->redirect(['rasxod/goods-list', 'rasxod_id' => $rasxod_id]);
    }

    /**
     * Finds the RasxodGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return RasxodGoods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RasxodGoods::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSelectGoodsAvailable(){

        $post = Yii::$app->request->post();
        $rasxod_id = $post['rasxod_id'];

        $data = RasxodGoods::findBySql('
            SELECT
                rg.id AS id,
                concat(g.code,"-",g.name) AS name
            FROM rasxod_goods rg
            LEFT JOIN goods g on g.id = rg.goods_id
            LEFT JOIN
            (
                SELECT 
                    rasxod_goods_id AS id,
                    SUM(amount) AS amount
                FROM prixod_goods
                GROUP BY 
                    rasxod_goods_id
            ) used ON used.id = rg.id
            
            WHERE (rg.amount - IFNULL(used.amount, 0)) > 0
                and rg.rasxod_id = :rasxod_id
            GROUP BY rg.id
        ')->params([':rasxod_id' => $rasxod_id])->asArray()->all();

        echo json_encode($data);
        die();
    }

    public function actionGetCostCurrency(){
        $post = Yii::$app->request->post();
        $rasxod_goods_id = $post['rasxod_goods_id'];
        $model = RasxodGoods::findOne($rasxod_goods_id); // проверка на существование
        if (!$model)
            return [];

        $used = PrixodGoods::find()
            ->where(['rasxod_goods_id' => $model->id])
            ->sum('amount') ?? 0;

        $free = $model->amount - $used;

        return json_encode(['cost' => $model->cost, 'amount' => $free, 'currency_id' => $model->currency_id, 'currency_name' => $model->currency->name]);
    }
}
