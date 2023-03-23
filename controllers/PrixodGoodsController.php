<?php

namespace app\controllers;

use app\models\Currency;
use app\models\CurrencyRates;
use app\models\Pricelist;
use app\models\PrixodGoods;
use app\models\Rasxod;
use app\models\RasxodGoods;
use app\models\search\PrixodGoodsSearch;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PrixodGoodsController implements the CRUD actions for PrixodGoods model.
 */
class PrixodGoodsController extends Controller
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
     * Lists all PrixodGoods models.
     *
     * @return string
     */
//    public function actionIndex()
//    {
//        $searchModel = new PrixodGoodsSearch();
//        $dataProvider = $searchModel->search($this->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Displays a single PrixodGoods model.
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
     * Creates a new PrixodGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
//    public function actionCreate()
//    {
//        $model = new PrixodGoods();
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
     * Updates an existing PrixodGoods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->cost_usd = CurrencyRates::getSummaUsd($model->prixod->date, $model->currency_id, $model->cost);
            $used = RasxodGoods::getPrixodedAmount($model->id);
            $curr_amount = $model->amount;

            if ($curr_amount < $used) {
                Yii::$app->session->setFlash('error', 'Уменьшился количество товара, минимальная количество которую можно уменьшить: ' . $used);
                return $this->redirect(Yii::$app->request->referrer);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                return $this->redirect(['prixod/goods-list', 'prixod_id' => $model->prixod_id]);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при сохранении данных'));
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateReturn($id)
    {
        $model = $this->findModel($id);
        $old_amount = $model->amount;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->cost_usd = CurrencyRates::getSummaUsd($model->prixod->date, $model->currency_id, $model->cost);
            $all_amount = RasxodGoods::findOne($model->rasxod_goods_id)->amount ?? 0;
            $used = PrixodGoods::find()
                ->where(['rasxod_goods_id' => $model->rasxod_goods_id])
                ->sum('amount');
            $curr_amount = $model->amount;
            $free = $all_amount - $used;

            if (($free + $old_amount) < $curr_amount) {
                Yii::$app->session->setFlash('error', 'Превишен количество товара ' . $model->goods->name . ' от расхода № ' . $model->rasxodedGoods->rasxod->number . ', доступное количество: ' . ($free + $old_amount));
                return $this->redirect(Yii::$app->request->referrer);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при сохранении данных'));
            }
            return $this->redirect(['prixod/goods-list', 'prixod_id' => $model->prixod_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PrixodGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $prixod_id = $model->prixod_id;

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно удалены'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка удаления данных'));
        }

        return $this->redirect(['prixod/goods-list', 'prixod_id' => $prixod_id]);
    }

    /**
     * Finds the PrixodGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PrixodGoods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PrixodGoods::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSelectGoodsAvailable()
    {

        $post = Yii::$app->request->post();
        $prixod_id = $post['prixod_id'];

        $data = PrixodGoods::findBySql('
            SELECT
                pg.id AS id,
                concat(g.code,"-",g.name) AS name
            FROM prixod_goods pg
            LEFT JOIN goods g on g.id = pg.goods_id
            LEFT JOIN
            (
                SELECT 
                    prixod_goods_id AS id,
                    SUM(amount) AS amount
                FROM rasxod_goods
                GROUP BY 
                    prixod_goods_id
            ) used ON used.id = pg.id
            
            WHERE (pg.amount - IFNULL(used.amount, 0)) > 0
                and pg.prixod_id = :prixod_id
            GROUP BY pg.id
        ')->params([':prixod_id' => $prixod_id])->asArray()->all();

        echo json_encode($data);
        die();
    }

    public function actionGetCostCurrency()
    {
        $post = Yii::$app->request->post();
        $prixod_goods_id = $post['prixod_goods_id'];
        $rasxod_id = $post['rasxod_id'];

        $model = PrixodGoods::findOne($prixod_goods_id); // проверка на существование
        if (!$model)
            return [];

        $rasxod = Rasxod::findOne($rasxod_id);

        $pricelist = Pricelist::find()
            ->where(['goods_id' => $model->goods_id])
            ->andWhere(['<=', 'date', dateBase($rasxod->date)])
            ->orderBy(['date' => SORT_DESC, 'id' => SORT_DESC])
            ->one();

        $used = RasxodGoods::find()
            ->where(['prixod_goods_id' => $model->id])
            ->sum('amount') ?? 0;

        $free = $model->amount - $used;
        $cost = $model->cost;
        $currency_id = $model->currency_id;
        $currency_name = $model->currency->name;

        if ($pricelist) {
            if ($rasxod->type == Rasxod::TYPE_CREDIT) {
                $cost = $pricelist->price_credit;
            }

            if ($rasxod->type == Rasxod::TYPE_TRANSFER) {
                $cost = $pricelist->price_transfer;
            }

            if ($rasxod->type == Rasxod::TYPE_FULL_PAYMENT) {
                $cost = $pricelist->price_full;
            }

            $currency_id = Currency::USD;
            $currency_name = 'USD';
        }

        return json_encode(['cost' => $cost, 'amount' => $free, 'currency_id' => $currency_id, 'currency_name' => $currency_name]);
    }
}
