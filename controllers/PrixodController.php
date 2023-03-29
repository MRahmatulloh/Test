<?php

namespace app\controllers;

use app\models\CurrencyRates;
use app\models\Movement;
use app\models\Prixod;
use app\models\PrixodGoods;
use app\models\search\Filter;
use app\models\search\PrixodGoodsSearch;
use app\models\search\PrixodSearch;
use PhpOffice\PhpWord\TemplateProcessor;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use function PHPUnit\Framework\fileExists;

/**
 * PrixodController implements the CRUD actions for Prixod model.
 */
class PrixodController extends Controller
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
     * Lists all Prixod models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PrixodSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Prixod model.
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
     * Creates a new Prixod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Prixod([
            'date' => date('d.m.Y'),
        ]);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->number = $model->getNumber();
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

    /**
     * Updates an existing Prixod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->type == $model::TYPE_MOVEMENT){
            $this->redirect(['index']);
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->number = $model->getNumber('update');
                $model->updated_by = Yii::$app->user->identity->getId();

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при сохранении данных'));
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Prixod model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Movement::findOne(['prixod_id' => $id])){
            Yii::$app->session->setFlash('error', Yii::t('app', 'Невозможно удалить приход, т.к. он связан с перемещением'));
            return $this->redirect(['index']);
        }

        if($model->prixodGoods){
            Yii::$app->session->setFlash('error', Yii::t('app', 'Невозможно удалить приход, так как в нем есть товары'));
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
     * Finds the Prixod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Prixod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prixod::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGoodsList($prixod_id)
    {
        $prixod = $this->findModel($prixod_id);
        $view = 'goods';

        if ($prixod->type == Prixod::TYPE_RETURN) {
            return $this->redirect(['return/goods-list', 'prixod_id' => $prixod_id]);
        }

        $searchModel = new PrixodGoodsSearch(['prixod_id' => $prixod_id]);
        $model = new PrixodGoods(['prixod_id' => $prixod_id]);
        $dataProvider = $searchModel->search($this->request->queryParams);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->cost_usd = CurrencyRates::getSummaUsd($model->prixod->date, $model->currency_id, $model->cost);

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при сохранении данных'));
                }
            }
        }

        if ($prixod->type == $prixod::TYPE_MOVEMENT){
            $view = 'goodslist_without_form';
        }

        return $this->render($view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionByGoods()
    {
        $searchModel = new PrixodGoodsSearch();

        $searchModel->from = date('Y-01-01');
        $searchModel->to = date('Y-m-d');

        $dataProvider = $searchModel->searchByGoods($this->request->queryParams);

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

            $variable = 'type';
            $value = null;
            if($prixod->type == $prixod::TYPE_RETURN)
                $value = 'Возврат';
            if($prixod->type == $prixod::TYPE_MOVEMENT)
                $value = 'Перемещение';
            $template->setValue($variable, $value);

            $variable = 'date';
            $value = dateView($prixod->date);
            $template->setValue($variable, $value);

            $variable = 'clientLocal';
            $value = $prixod->client->name;
            $value = str_replace('&', '&amp;', $value);
            $template->setValue($variable, $value);

            $variable = 'client';
            $value = 'ООО «7 MARKET»';
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

    public function actionPrintCount($id)
    {
        $prixod = $this::findModel($id);
        $path = 'files/templates/';

        if (!empty($prixod)) {
            $file = 'talabnoma_bez_summi.docx';
            $template = new TemplateProcessor( $path . $file);

            $variable = 'number';
            $value = $prixod->number;
            $template->setValue($variable, $value);

            $variable = 'date';
            $value = dateView($prixod->date);
            $template->setValue($variable, $value);

            $variable = 'clientLocal';
            $value = $prixod->client->name;
            $value = str_replace('&', '&amp;', $value);
            $template->setValue($variable, $value);

            $variable = 'type';
            $value = null;
            if($prixod->type == $prixod::TYPE_RETURN)
                $value = 'Возврат';
            if($prixod->type == $prixod::TYPE_MOVEMENT)
                $value = 'Перемещение';
            $template->setValue($variable, $value);

            $variable = 'client';
            $value = 'ООО «7 MARKET»';
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

    public function actionNakladnoy($prixod_id)
    {
        $this->layout = 'other';
        $searchModel = new PrixodGoodsSearch(['prixod_id' => $prixod_id]);
        $model = new PrixodGoods(['prixod_id' => $prixod_id]);
        $dataProvider = $searchModel->search($this->request->queryParams);

        if ($this->request->isPost) {
            $post = $this->request->post();
            $base64_string = $post['data'];
            $filename = 'image.jpg';

            $base64_string = str_replace('data:image/png;base64,', '', $base64_string);
            $base64_string = str_replace(' ', '+', $base64_string);

            $fileData = base64_decode($base64_string);
            file_put_contents($filename, $fileData);
            $telegram = Yii::$app->telegram;
            $telegram->sendPhoto([
                'chat_id' => '-1001937395913',
                'caption' => "№".$model->prixod->number." ".date("d.m.Y", strtotime($model->prixod->date)),
                'photo' => $filename,
            ]);
        }


        return $this->render('nakladnoy', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
}
