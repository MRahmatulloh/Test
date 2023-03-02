<?php

namespace app\controllers;

use app\models\CurrencyRates;
use app\models\PrixodGoods;
use app\models\Rasxod;
use app\models\RasxodGoods;
use app\models\search\PrixodGoodsSearch;
use app\models\search\RasxodGoodsSearch;
use app\models\search\RasxodSearch;
use PhpOffice\PhpWord\TemplateProcessor;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use function PHPUnit\Framework\fileExists;

/**
 * RasxodController implements the CRUD actions for Rasxod model.
 */
class RasxodController extends Controller
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
     * Lists all Rasxod models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RasxodSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rasxod model.
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
     * Creates a new Rasxod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Rasxod([
            'date' => date('d.m.Y'),
        ]);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->number = $model->getNumber('create', 'R');
                $model->created_by = Yii::$app->user->identity->getId();

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка сохранения данных'));
                }

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Rasxod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->number = $model->getNumber('update', 'R');
                $model->updated_by = Yii::$app->user->identity->getId();

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка сохранения данных'));
                }

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Rasxod model.
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
     * Finds the Rasxod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Rasxod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rasxod::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGoodsList($rasxod_id)
    {
        $searchModel = new RasxodGoodsSearch(['rasxod_id' => $rasxod_id]);
        $model = new RasxodGoods(['rasxod_id' => $rasxod_id]);
        $dataProvider = $searchModel->search($this->request->queryParams);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->cost_usd = CurrencyRates::getSummaUsd($model->rasxod->date, $model->currency_id, $model->cost);

                if ($model->prixod_goods_id) {
                    $model->goods_id = $model->prixodGoods->goods_id;
                    $used = RasxodGoods::getPrixodedAmount($model->prixod_goods_id) ?? 0;
                    $free = $model->prixodGoods->amount - $used;

                    if (($free - $model->amount) < 0) {
                        Yii::$app->session->setFlash('error', 'Не хвататет количество товара ' . $model->prixodGoods->goods->name . ', доступное количество: ' . $free);
                        return $this->redirect(['rasxod/goods-list', 'rasxod_id' => $model->rasxod_id]);
                    }
                }

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка сохранения данных'));
                }

                return $this->redirect(['goods-list', 'rasxod_id' => $model->rasxod_id]);
            }
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->cost_usd = CurrencyRates::getSummaUsd($model->rasxod->date, $model->currency_id, $model->cost);

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка сохранения данных'));
                }

                prd($model->errors);

                return $this->redirect(Yii::$app->request->referrer);
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
        $searchModel = new RasxodGoodsSearch();

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

    public function actionPrint($id)
    {
        $prixod = $this::findModel($id);
        $path = 'files/templates/';

        if (!empty($prixod)) {
            $file = 'talabnoma.docx';
            $template = new TemplateProcessor( $path . $file);

            $variable = 'number';
            $value = $prixod->number;
            $template->setValue($variable, $value);

            $variable = 'date';
            $value = dateView($prixod->date);
            $template->setValue($variable, $value);

            $variable = 'client';
            $value = $prixod->client->name;
            $value = str_replace('&', '&amp;', $value);
            $template->setValue($variable, $value);

            $variable = 'warehouse';
            $value = $prixod->warehouse->name;
            $template->setValue($variable, $value);

            $result = $prixod->prixodGoods;

            // tovar degan shablon bor satrni nusxalash
            $template->cloneRow('tovar', count($result));
            $k = 1;
            $summa = 0;
            $summa_amount = 0;
            /** @var $tovar PrixodGoods */
            foreach ($result as $tovar) {

                $kk = $tovar->amount * $tovar->cost;
                $summa += $kk;
                $summa_amount += $tovar->amount;

                $variable = 'n#' . $k;
                $value = $k;
                $template->setValue($variable, $value);

                $variable = 'tovar#' . $k;
                $value = $tovar->goods->code . '-' . $tovar->goods->name;
                $value = str_replace("&", " ", $value);
                $template->setValue($variable, $value);

                $variable = 'u#' . $k;
                $value = 'шт.';
                $template->setValue($variable, $value);

                $variable = 'amount#' . $k;
                $value = pul2($tovar->amount, 2);
                $template->setValue($variable, $value);

                $variable = 'cost#' . $k;
                $value = pul2($tovar->cost, 2);
                $template->setValue($variable, $value);

                $variable = 'money#' . $k;
                $value = $tovar->currency->name;
                $template->setValue($variable, $value);

                $variable = 'summa#' . $k;
                $value = pul2($kk, 2);
                $template->setValue($variable, $value);

                $k++;
            }

            $variable = 'amo_total';
            $value = pul2($summa_amount, 2);
            $template->setValue($variable, $value);

            $variable = 'sum_total';
            $value = pul2($summa, 2);
            $template->setValue($variable, $value);

            $date = str_replace("-", "_", DateBase($prixod->date));
            $number = str_replace("/", "_", $prixod->number);
            $path .= $date . '_' . $number . '_' . 'nakladnoy.docx';

            $template->saveAs($path);
            $real_file = \Yii::getAlias('@webroot') . '/' . $path;

            $resp = \Yii::$app->response->sendFile($real_file);

            if (fileExists($real_file))
                unlink($real_file);

            return $resp;
        }
        echo "okey brat";
    }
}
