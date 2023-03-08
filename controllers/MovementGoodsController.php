<?php

namespace app\controllers;

use app\models\CurrencyRates;
use app\models\MovementGoods;
use app\models\PrixodGoods;
use app\models\RasxodGoods;
use app\models\search\MovementGoodsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MovementGoodsController implements the CRUD actions for MovementGoods model.
 */
class MovementGoodsController extends Controller
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
     * Lists all MovementGoods models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MovementGoodsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MovementGoods model.
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
     * Creates a new MovementGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
//    public function actionCreate()
//    {
//        $model = new MovementGoods();
//
//        if ($this->request->isPost) {
//            if ($model->load($this->request->post()) && $model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
//        } else {
//            $model->loadDefaultValues();
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Updates an existing MovementGoods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($this->request->isPost && $model->load($this->request->post())) {
//            if ($model->save()) {
//                Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
//                return $this->redirect(['movement/goods-list', 'id' => $model->movement_id]);
//            } else {
//                Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при сохранении данных'));
//            }
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_amount = $model->amount;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $all_amount = RasxodGoods::findOne($model->rasxod_goods_id)->amount;
            $used = PrixodGoods::find()
                ->where(['rasxod_goods_id' => $model->rasxod_goods_id])
                ->sum('amount');
            $used_movement = MovementGoods::find()
                ->where(['rasxod_goods_id' => $model->rasxod_goods_id, 'movement_id' => $model->movement_id])
                ->sum('amount') ?? 0;

            $curr_amount = $model->amount;
            $free = $all_amount - $used - $used_movement;

            if (($free + $old_amount ) < $curr_amount){
                Yii::$app->session->setFlash('error', 'Превишен количество товара ' . $model->goods->name  . ' от расхода № '. $model->rasxodGoods->rasxod->number .', доступное количество: ' . ($free + $old_amount));
                return $this->redirect(Yii::$app->request->referrer);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при сохранении данных'));
            }
            return $this->redirect(['movement/goods-list', 'id' => $model->movement_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MovementGoods model.
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
     * Finds the MovementGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MovementGoods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MovementGoods::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
