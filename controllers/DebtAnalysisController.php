<?php

namespace app\controllers;

use app\models\search\BalanceSearch;
use Yii;
use yii\data\SqlDataProvider;
use yii\web\Controller;

class DebtAnalysisController extends MyController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($to = null, $from = null, $client_id = null, $type = null)
    {
        $searchModel = new BalanceSearch();
        $searchModel->load(Yii::$app->request->queryParams);
        $from = $from ?: date('Y-01-01');
        $to = $to ?: date('Y-m-d');
        $params = [
            ':from' => $from,
            ':to' => $to,
        ];
        $stats = [
            'prixod' => 0,
            'rasxod' => 0,
        ];

        if (strtotime($from) > strtotime($to)) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Неверно указан период дат'));
            return $this->redirect(Yii::$app->request->referrer);
        }

        $sql = "
        select
            t.*,
            c.name as client_name
        from
        (
            select
                ifnull(sum(pg.cost_usd * pg.amount), 0) as summa,
                'product-in' as type,
                pg.prixod_id as id,
                p.date,
                p.client_id
            from prixod_goods pg
            left join prixod p on p.id = pg.prixod_id
            group by pg.prixod_id
    
            union all
    
            select
                ifnull(sum(rg.cost_usd * rg.amount), 0) as summa,
                'product-out' as type,
                rg.rasxod_id as id,
                r.date,
                r.client_id
            from rasxod_goods rg
            left join rasxod r on r.id = rg.rasxod_id
            group by rg.rasxod_id
    
            union all
    
            select
                ifnull(sum(e.summa_usd), 0) as summa,
                'money-out' as type,
                e.id,
                e.date,
                e.client_id
            from expense e
            group by e.id
    
            union all
    
            select
                ifnull(sum(p.summa_usd), 0) as summa,
                'money-in' as type,
                p.id,
                p.date,
                p.client_id
            from payment p
            group by p.id
    
        ) as t
        
        left join client c on c.id = t.client_id

        where
            t.date between :from and :to
        ";

        if ($client_id) {
            $sql .= " and t.client_id = :client_id";
            $params = array_merge($params, [':client_id' => $client_id]);
        }

        if ($type) {
            $sql .= " and t.type = :type";
            $params = array_merge($params, [':type' => $type]);
        }

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => $params,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ],
                'attributes' => [
                    'client_id',
                    'client_name',
                    'date',
                    'type',
                    'id',
                    'summa'
                ],
            ],
            'pagination' => [
                'pageSize' => $searchModel->myPageSize ?? 20,
            ]
        ]);

        foreach ($dataProvider->models as $model) {
            if ($model['type'] == 'product-in' or $model['type'] == 'money-in') {
                $stats['prixod'] += $model['summa'];
            } elseif ($model['type'] == 'product-out' or $model['type'] == 'money-out') {
                $stats['rasxod'] += $model['summa'];
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'to' => $to,
            'from' => $from,
            'client_id' => $client_id,
            'type' => $type,
            'stats' => $stats,
        ]);
    }
}
