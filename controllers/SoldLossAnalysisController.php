<?php

namespace app\controllers;

use app\models\search\BalanceSearch;
use app\models\search\RasxodGoodsSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Controller;

class SoldLossAnalysisController extends MyController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($to = null, $from = null, $client_id = null, $type = null)
    {
        $searchModel = new RasxodGoodsSearch();
        $searchModel->load(Yii::$app->request->queryParams);
        $from = $from ?: date('Y-01-01');
        $to = $to ?: date('Y-m-d');

        if (strtotime($from) > strtotime($to)) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Неверно указан период дат'));
            return $this->redirect(Yii::$app->request->referrer);
        }

        $query = RasxodGoodsSearch::find()
            ->joinWith(['prixodGoods as pg', 'rasxod as r'])
            ->where('rasxod_goods.cost_usd < pg.cost_usd')
            ->andWhere(['>=', 'r.date', $from])
            ->andWhere(['<=', 'r.date', $to]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'to' => $to,
            'from' => $from,
        ]);
    }
}
