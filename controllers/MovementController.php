<?php

namespace app\controllers;

use app\models\Movement;
use app\models\MovementGoods;
use app\models\PrixodGoods;
use app\models\RasxodGoods;
use app\models\search\MovementGoodsSearch;
use app\models\search\MovementSearch;
use Yii;
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
                    $already_amount = MovementGoods::find()
                        ->where(['rasxod_goods_id' => $model->rasxod_goods_id, 'movement_id' => $model->movement_id])
                        ->sum('amount') ?? 0;

                    $model->currency_id = $rasxod_goods->currency_id;
                    $model->cost_return = $rasxod_goods->cost;
                    $model->goods_id = $rasxod_goods->goods_id;

                    $used = PrixodGoods::getRasxodedAmount($model->rasxod_goods_id) ?? 0;
                    $free = $rasxod_goods->amount - $used - $already_amount;

                    if (($free - $model->amount) < 0) {
                        Yii::$app->session->setFlash('error', 'Превишен количество товара ' . $rasxod_goods->goods->name . ' от расхода № ' . $rasxod_goods->rasxod->number . ', доступное количество: ' . $free);
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

    public function actionByGoods()
    {
        $searchModel = new MovementGoodsSearch();

        $searchModel->from = date('Y-01-01');
        $searchModel->to = date('Y-m-d');

        $dataProvider = $searchModel->search($this->request->queryParams);

        $searchModel->from = dateView($searchModel->from);
        $searchModel->to = dateView($searchModel->to);
        return $this->render('by-goods', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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
            $model->number = $model->getNumber('update', 'M');
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

    public function actionAccept($id)
    {
        $model = $this->findModel($id);

        $model->accept();
        Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));

        return $this->redirect(['index']);
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
        $model = $this->findModel($id);

        if($model->movementGoods){
            Yii::$app->session->setFlash('error', Yii::t('app', 'Невозможно удалить перемещение, так как в нем есть товары'));
            return $this->redirect(['index']);
        }

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно удалены'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при удаления данных'));
        }

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
