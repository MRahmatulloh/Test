<?php

namespace app\controllers;

use app\models\search\BalanceSearch;
use app\models\search\RasxodSearch;
use Yii;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Controller;

class BalanceController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BalanceSearch([
            'warehouse_id' => 1
        ]);

        $searchModel->load(Yii::$app->request->get());
        $params = [];

        $sql = "
            select g.name                                               as goods_name,
                   g.code                                               as goods_code,
                   g.id                                                 as goods_id,
                   g.img                                                as goods_img,
                   ifnull(income.amount, 0)                             as in_amount,
                   ifnull(outcome.amount, 0)                            as out_amount,
                   ifnull(income.amount, 0) - ifnull(outcome.amount, 0) as ostatok,
                   :warehouse_id                                        as warehouse_id,
                   IF(:warehouse_id is null, 'All', w.name)             as warehouse_name
            from goods g
            
                     left join (select pg.goods_id,
                                       sum(pg.amount) as amount
                                from prixod_goods pg
                                         left join prixod p on pg.prixod_id = p.id
                                where 1 = 1 ";

        if ($searchModel->warehouse_id) {
            $sql .= "               and p.warehouse_id = :warehouse_id ";
        }
        if ($searchModel->goods_id) {
            $sql .= "               and pg.goods_id = :goods_id ";
        }

        $sql .= "                                                                
                                group by pg.goods_id) as income on income.goods_id = g.id
            
                     left join (select rg.goods_id,
                                       sum(rg.amount) as amount
                                from rasxod_goods rg
                                         left join rasxod r on rg.rasxod_id = r.id
                                where 1 = 1 ";

        if ($searchModel->warehouse_id) {
            $sql .= "               and r.warehouse_id = :warehouse_id ";
        }
        if ($searchModel->goods_id) {
            $sql .= "               and rg.goods_id = :goods_id ";
        }

        $sql .= "
                                group by rg.goods_id) as outcome on outcome.goods_id = g.id
            
                     left join warehouse w on w.id = :warehouse_id
            
            where g.id in (select pg2.goods_id
                           from prixod_goods pg2
                           group by pg2.goods_id
            
                           union all
            
                           select rg2.goods_id
                           from rasxod_goods rg2
                           group by rg2.goods_id) ";

        if ($searchModel->goods_id) {
            $sql .= " and g.id = :goods_id ";
            $params = array_merge($params, [':goods_id' => $searchModel->goods_id]);
        }
        $params = array_merge($params, [':warehouse_id' => $searchModel->warehouse_id]);

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => $params,
            'sort' => [
                'defaultOrder' => [
                    'ostatok' => SORT_DESC,
                ],
                'attributes' => [
                    'goods_id',
                    'in_amount',
                    'out_amount',
                    'warehouse_id',
                    'ostatok'
                ],
            ],
            'pagination' => [
                'pageSize' => 100
            ]
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
