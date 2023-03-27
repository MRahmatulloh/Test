<?php
namespace app\services;
use app\models\Client;
use app\models\Goods;
use app\models\User;
use app\models\Warehouse;
use Yii;
use yii\base\Model;

class DashboardDataService extends Model
{

    public function getData($from, $to)
    {
        $result = [];

        $sale_sql = "
            select
                round(ifnull(sum(t.rasxod_summa), 0), 2) as rasxod_summa,
                round(ifnull(sum(t.prixod_summa), 0), 2) as prixod_summa,
                round(ifnull(sum(t.profit_summa), 0), 2) as profit_summa,
                t.date
            from (
            select
                round(ifnull(sum(rg.cost_usd * rg.amount), 0), 2) as rasxod_summa,
                0 prixod_summa,
                0 profit_summa,
                r.date
            from rasxod_goods rg
            left join rasxod r on r.id = rg.rasxod_id
            where r.date between :from and :to
            group by r.date 
                
            union all
            
            select
                0 rasxod_summa,
                round(ifnull(sum(pg.cost_usd * pg.amount), 0), 2) as prixod_summa,
                0 profit_summa,                
                p.date
            from prixod_goods pg
            left join prixod p on p.id = pg.prixod_id
            where p.date between :from and :to
            group by p.date
            
            union all
            
            select
                0 rasxod_summa,
                0 prixod_summa,
                round(ifnull(sum((rg.cost_usd - pg.cost_usd) * rg.amount), 0), 2) as profit_summa,
                r.date
            from rasxod_goods rg
            left join rasxod r on r.id = rg.rasxod_id
            left join prixod_goods pg on pg.id = rg.prixod_goods_id
            where r.date between :from and :to
            group by r.date
            ) t
            group by t.date
            order by t.date
        ";

        $result['sales'] = Yii::$app->db->createCommand($sale_sql)
            ->bindValue(':from', $from)
            ->bindValue(':to', $to)
            ->queryAll();

        $result['sales_total'] = [
            'rasxod' => array_sum(array_column($result['sales'], 'rasxod_summa')),
            'prixod' => array_sum(array_column($result['sales'], 'prixod_summa')),
            'profit' => array_sum(array_column($result['sales'], 'profit_summa')),
        ];

        $kassa_sql = "
            select
                round(sum(ifnull(t.chiqim_summa, 0)), 2) as chiqim_summa,
                round(sum(ifnull(t.kirim_summa, 0)), 2) as kirim_summa,
                t.date
            from (
                     select
                         round(ifnull(sum(e.summa_usd), 0), 2) as chiqim_summa,
                         0 as kirim_summa,
                         e.date as date
                     from expense e
                     where e.date between :from and :to
                     group by e.date
            
                     union all
            
                     select
                         0 as chiqim_summa,
                         round(ifnull(sum(p.summa_usd), 0), 2) as kirim_summa,
                         p.date as date
                     from payment p
                     where p.date between :from and :to
                     group by p.date
            
                 ) as t
            
            group by t.date 
            order by t.date
        ";

        $result['kassa'] = Yii::$app->db->createCommand($kassa_sql)
            ->bindValue(':from', $from)
            ->bindValue(':to', $to)
            ->queryAll();

        $result['kassa_total'] = [
            'kassa_kirim' => array_sum(array_column($result['kassa'], 'kirim_summa')),
            'kassa_chiqim' => array_sum(array_column($result['kassa'], 'chiqim_summa')),
        ];

        $result['goods_total'] = Goods::find()->count();
        $result['clients_total'] = Client::find()->count();
        $result['users_total'] = User::find()->count();
        $result['warehouses_total'] = Warehouse::find()->count();

        $top_clients_sql = "
            select
                c.name,
                round(ifnull(sum(rg.cost_usd), 0), 2) as summa
            from rasxod_goods rg
                     left join rasxod r on r.id = rg.rasxod_id
                     left join client c on c.id = r.client_id
            where r.date between :from and :to
            group by c.name
            order by summa desc
            limit 5
        ";

        $result['top_clients'] = Yii::$app->db->createCommand($top_clients_sql)
            ->bindValue(':from', $from)
            ->bindValue(':to', $to)
            ->queryAll();

        $top_goods_sql = "
            select
                concat(g.code,'-',g.name) as name,
                sum(rg.amount) as amount,
                round(ifnull(sum(rg.cost_usd * rg.amount), 0), 2) as summa
            from rasxod_goods rg
                     left join rasxod r on r.id = rg.rasxod_id
                     left join goods g on g.id = rg.goods_id
            where r.date between :from and :to
            group by g.name
            order by summa desc
            limit 7
        ";

        $result['top_goods'] = Yii::$app->db->createCommand($top_goods_sql)
            ->bindValue(':from', $from)
            ->bindValue(':to', $to)
            ->queryAll();

        $warehouse_sql = "
            select
                   round(sum((pg.amount - ifnull(rg.amount, 0)) * pg.cost_usd), 2)  as summa,
                   sum(pg.amount - ifnull(rg.amount, 0))                            as amount
            from prixod_goods pg
                     left join (select rg.prixod_goods_id,
                                       sum(rg.amount) as amount
                                from rasxod_goods rg
                                group by rg.prixod_goods_id) rg on pg.id = rg.prixod_goods_id
        ";

        $result['warehouse'] = Yii::$app->db->createCommand($warehouse_sql)->queryOne();

        return $result;
    }

    private function getKassaData($from, $to){

    }

}