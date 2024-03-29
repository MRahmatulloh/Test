<?php

namespace app\modules\cash\controllers;

use app\controllers\MyController;
use app\models\CurrencyRates;
use app\modules\cash\models\Expense;
use app\modules\cash\models\search\ExpenseSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExpenseController implements the CRUD actions for Expense model.
 */
class ExpenseController extends MyController
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
     * Lists all Expense models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ExpenseSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Expense model.
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
     * Creates a new Expense model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Expense([
            'date' => date('d.m.Y'),
        ]);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->created_by = Yii::$app->user->identity->id;
                $model->summa_usd = CurrencyRates::getSummaUsd($model->date, $model->currency_id, $model->summa);

                if ($model->save()){
                    Yii::$app->session->setFlash('success', 'Данные успешно сохранены');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка сохранения данных');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Expense model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->updated_by = Yii::$app->user->identity->id;
            $model->summa_usd = CurrencyRates::getSummaUsd($model->date, $model->currency_id, $model->summa);

            if ($model->save()){
                Yii::$app->session->setFlash('success', 'Данные успешно сохранены');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка сохранения данных');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Expense model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно удалены'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при удаления данных'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Expense model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Expense the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Expense::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
