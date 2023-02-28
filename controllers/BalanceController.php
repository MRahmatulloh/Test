<?php

namespace app\controllers;

use app\models\search\BalanceSearch;
use app\models\search\RasxodSearch;
use Yii;
use yii\data\ArrayDataProvider;
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

        $sql = "
            select g.name                                               as goods_name,
                   g.code                                               as goods_code,
                   g.id                                                 as goods_id,
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
                                where 1 = 1
                                      #and p.warehouse_id = 1
                                      #and pg.goods_id = 2
                                group by pg.goods_id) as income on income.goods_id = g.id
            
                     left join (select rg.goods_id,
                                       sum(rg.amount) as amount
                                from rasxod_goods rg
                                         left join rasxod r on rg.rasxod_id = r.id
                                where 1 = 1
                                      #and r.warehouse_id = 1
                                      #and rg.goods_id = 2
                                group by rg.goods_id) as outcome on outcome.goods_id = g.id
            
                     left join warehouse w on w.id = :warehouse_id
            
            where g.id in (select pg2.goods_id
                           from prixod_goods pg2
                           group by pg2.goods_id
            
                           union all
            
                           select rg2.goods_id
                           from rasxod_goods rg2
                           group by rg2.goods_id)
              and g.id = 2        
        ";

        $params = [];

        if($searchModel->load(Yii::$app->request->get())) {

            if ($searchModel->warehouse_id) {
                $sql .= ' and  united.warehouse_id = :warehouse_id ';
                $params = array_merge($params, [':warehouse_id' => $searchModel->warehouse_id]);
            }

            if ($searchModel->goods_id) {
                $sql .= ' and  united.goods_id = :goods_id ';
                $params = array_merge($params, [':goods_id' => $searchModel->goods_id]);
            }
        }else{
            $sql .= ' and  united.warehouse_id = :warehouse_id ';
            $params = array_merge($params, [':warehouse_id' => $searchModel->warehouse_id]);
        }

        $sql .= ' group by united.tip, united.goods_id ';

        $data = \Yii::$app->db->createCommand($sql, $params)->queryAll();
        prd(\Yii::$app->db->createCommand($sql, $params)->getRawSql());
        $united = [];

        if ($data){
            $goods_list = array_unique(array_column($data, 'goods_id'));

            if ($goods_list){
                foreach ($goods_list as $item)
                    $united[] = [
                        'goods_id' => $item,
                        'goods_code' => 0,
                        'goods_name' => 0,
                        'in_amount' => 0,
                        'out_amount' => 0,
                        'warehouse_id' => 0,
                        'warehouse_name' => 0,
                        'ostatok' => 0
                    ];
            }

            foreach ($data as $ditem) {
                foreach ($united as $key => $uitem) {
                    if ($ditem['goods_id'] == $uitem['goods_id']){
                        $united[$key]['goods_code'] = $ditem['goods_code'];
                        $united[$key]['goods_name'] = $ditem['goods_name'];
                        $united[$key]['warehouse_id'] = $ditem['warehouse_id'];
                        $united[$key]['warehouse_name'] = $ditem['warehouse_name'];

                        if ($ditem['tip'] == 1)
                            $united[$key]['in_amount'] += $ditem['amount'];

                        if ($ditem['tip'] == 2)
                            $united[$key]['out_amount'] += $ditem['amount'];

                        $united[$key]['ostatok'] = $united[$key]['in_amount'] - $united[$key]['out_amount'];
                    }
                }
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $united,
            'sort' => [
                'defaultOrder' => [
                    'ostatok' => 'SORT_DESC',
                ],

                'attributes' => [
                    'goods_id',
                    'in_amount',
                    'out_amount',
                    'warehouse_id',
                    'ostatok'
                ],
            ],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex1()
    {
        $searchModel = new BalanceSearch([
            'warehouse_id' => 1
        ]);

        $sql = '
            select 
                sum(united.amount) AS amount,
                united.goods_id,
                g.code goods_code,
                g.name goods_name,
                w.name warehouse_name,
                united.tip,
                united.warehouse_id
            from
                (
                    (select 
                        pg.amount,
                        pg.goods_id,
                        p.warehouse_id,
                        1 AS tip
                    from prixod_goods pg
                    left join prixod p on pg.prixod_id = p.id)
                    
                    union all
                    
                    (select 
                        og.amount,
                        og.goods_id,
                        o.warehouse_id,
                        2 AS tip
                    from rasxod_goods og
                    left JOIN `rasxod` o on og.rasxod_id = o.id)
                ) as united 
            LEFT JOIN goods g ON united.goods_id = g.id
            left join warehouse w on united.warehouse_id = w.id
            where 1 = 1 
            ';

        $params = [];

        if($searchModel->load(Yii::$app->request->get())) {

            if ($searchModel->warehouse_id) {
                $sql .= ' and  united.warehouse_id = :warehouse_id ';
                $params = array_merge($params, [':warehouse_id' => $searchModel->warehouse_id]);
            }

            if ($searchModel->goods_id) {
                $sql .= ' and  united.goods_id = :goods_id ';
                $params = array_merge($params, [':goods_id' => $searchModel->goods_id]);
            }
        }else{
            $sql .= ' and  united.warehouse_id = :warehouse_id ';
            $params = array_merge($params, [':warehouse_id' => $searchModel->warehouse_id]);
        }

        $sql .= ' group by united.tip, united.goods_id ';

        $data = \Yii::$app->db->createCommand($sql, $params)->queryAll();
        prd(\Yii::$app->db->createCommand($sql, $params)->getRawSql());
        $united = [];

        if ($data){
            $goods_list = array_unique(array_column($data, 'goods_id'));

            if ($goods_list){
                foreach ($goods_list as $item)
                    $united[] = [
                        'goods_id' => $item,
                        'goods_code' => 0,
                        'goods_name' => 0,
                        'in_amount' => 0,
                        'out_amount' => 0,
                        'warehouse_id' => 0,
                        'warehouse_name' => 0,
                        'ostatok' => 0
                    ];
            }

            foreach ($data as $ditem) {
                foreach ($united as $key => $uitem) {
                    if ($ditem['goods_id'] == $uitem['goods_id']){
                        $united[$key]['goods_code'] = $ditem['goods_code'];
                        $united[$key]['goods_name'] = $ditem['goods_name'];
                        $united[$key]['warehouse_id'] = $ditem['warehouse_id'];
                        $united[$key]['warehouse_name'] = $ditem['warehouse_name'];

                        if ($ditem['tip'] == 1)
                            $united[$key]['in_amount'] += $ditem['amount'];

                        if ($ditem['tip'] == 2)
                            $united[$key]['out_amount'] += $ditem['amount'];

                        $united[$key]['ostatok'] = $united[$key]['in_amount'] - $united[$key]['out_amount'];
                    }
                }
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $united,
            'sort' => [
                'defaultOrder' => [
                    'ostatok' => 'SORT_DESC',
                ],

                'attributes' => [
                    'goods_id',
                    'in_amount',
                    'out_amount',
                    'warehouse_id',
                    'ostatok'
                ],
            ],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
