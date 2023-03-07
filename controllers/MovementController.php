<?php

namespace app\controllers;

use app\models\CurrencyRates;
use app\models\Movement;
use app\models\MovementGoods;
use app\models\PrixodGoods;
use app\models\RasxodGoods;
use app\models\search\MovementGoodsSearch;
use app\models\search\MovementSearch;
use app\models\search\PrixodGoodsSearch;
use Yii;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MovementController implements the CRUD actions for Movement model.
 */
class MovementController extends Controller
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
     * Lists all Movement models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MovementSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Movement model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Movement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Movement([
            'date' => date('d.m.Y'),
        ]);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->number = $model->getNumber('create', 'M');
                $model->created_by = Yii::$app->user->identity->getId();

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при сохранении данных'));
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionGoodsList($id)
    {
        $this->findModel($id);
        $searchModel = new MovementGoodsSearch(['movement_id' => $id]);
        $model = new MovementGoods(['movement_id' => $id]);
        $dataProvider = $searchModel->search($this->request->queryParams);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->rasxod_goods_id) {
                    $rasxod_goods = RasxodGoods::findOne($model->rasxod_goods_id);

                    $model->cost = $rasxod_goods->cost;
                    $model->currency_id = $rasxod_goods->currency_id;

                    $model->cost_usd = CurrencyRates::getSummaUsd($model->movement->date, $model->currency_id, $model->cost);
                    $model->goods_id = $rasxod_goods->goods_id;
                    $used = PrixodGoods::getRasxodedAmount($model->rasxod_goods_id) ?? 0;
                    $free = $rasxod_goods->amount - $used;

                    if (($free - $model->amount) < 0) {
                        Yii::$app->session->setFlash('error', 'Превишен количество товара ' . $rasxod_goods->goods->name . ' от расхода, доступное количество: ' . $free);
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при сохранении данных'));
                }
            }
        }

        return $this->render('goods', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Movement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->number = $model->getNumber('create', 'M');
            $model->updated_by = Yii::$app->user->identity->getId();

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при сохранении данных'));
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Movement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Movement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Movement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Movement::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
