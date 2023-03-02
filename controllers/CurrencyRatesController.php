<?php

namespace app\controllers;

use app\models\Currency;
use app\models\CurrencyRates;
use app\models\search\CurrencyRatesSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CurrencyRatesController implements the CRUD actions for CurrencyRates model.
 */
class CurrencyRatesController extends Controller
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
     * Lists all CurrencyRates models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CurrencyRatesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CurrencyRates model.
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
     * Creates a new CurrencyRates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CurrencyRates(['date' => date('d.m.Y')]);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка сохранения данных'));
                    return $this->redirect(Yii::$app->request->referrer);
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CurrencyRates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка сохранения данных'));
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CurrencyRates model.
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
     * Finds the CurrencyRates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CurrencyRates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CurrencyRates::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdateKurs($date = null)
    {
        $date = $date ?? date('Y-m-d');
        $currency_codes = array_keys(Currency::selectListByCode() ?? []);

        foreach ($currency_codes ?? [] as $currency_code) {
            if ($currency_code != 860)
                $this::getKursByBankAPI($date, $currency_code);
        }

        return $this->redirect(['index']);
    }

    public static function getKursByBankAPI($date, int $currency_code)
    {
        switch ($currency_code) {
            case 840:
                $valyuta = 'USD';
                break;
            case 976:
                $valyuta = 'EUR';
                break;
            case 643:
                $valyuta = 'RUB';
                break;
            case 156:
                $valyuta = 'CNY';
                break;
        }

        // http://cbu.uz/uzc/arkhiv-kursov-valyut/veb-masteram/

        $xmlfile = file_get_contents("http://cbu.uz/uzc/arkhiv-kursov-valyut/xml/" . $valyuta . "/" . $date . "/");
        $ob = simplexml_load_string($xmlfile);
        $json = json_encode($ob);
        $configData = json_decode($json, true);

        $result = $configData['CcyNtry'];

        $last = CurrencyRates::find()
            ->where(['code' => $currency_code])
            ->andwhere(['<=', 'date', $date])
            ->orderBy(['date' => SORT_DESC])
            ->one();

        if ($last) {

            if ($result['Rate'] != $last->rate) {
                $model = new CurrencyRates();
                $model->code = $currency_code;
                $model->rate = $result['Rate'];
                $model->date = dateBase($result['date']);
                $model->created_at = time();
                $model->updated_at = time();
                $model->save();
            }

        } else {
            $model = new CurrencyRates();
            $model->code = $currency_code;
            $model->rate = $result['Rate'];
            $model->date = dateBase($result['date']);
            $model->created_at = time();
            $model->updated_at = time();
            $model->save();
        }

    }

}
