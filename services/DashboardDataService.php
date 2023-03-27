<?php
namespace app\services;
use Yii;
use yii\base\Model;

class DashboardDataService extends Model
{
    public function getData($from, $to)
    {
        $result = [];

        $rasxod_sql = "
                select
                    round(ifnull(sum(rg.cost_usd * rg.amount), 0), 2) as summa,
                    r.date
                from rasxod_goods rg
                left join rasxod r on r.id = rg.rasxod_id
                where r.date between :from and :to
                group by r.date 
        ";

        $prixod_sql = "
            select
                round(ifnull(sum(pg.cost_usd * pg.amount), 0), 2) as summa,
                p.date
            from prixod_goods pg
            left join prixod p on p.id = pg.prixod_id
            where p.date between :from and :to
            group by p.date
        ";

        $profit_sql = "
                select
                    round(ifnull(sum((rg.cost_usd - pg.cost_usd) * rg.amount), 0), 2) as summa,
                    r.date
                from rasxod_goods rg
                left join rasxod r on r.id = rg.rasxod_id
                left join prixod_goods pg on pg.id = rg.prixod_goods_id
                where r.date between :from and :to
                group by r.date
        ";

        $result['rasxod'] = Yii::$app->db->createCommand($rasxod_sql)
            ->bindValue(':from', $from)
            ->bindValue(':to', $to)
            ->queryAll();

        $result['prixod'] = Yii::$app->db->createCommand($prixod_sql)
            ->bindValue(':from', $from)
            ->bindValue(':to', $to)
            ->queryAll();

        $result['profit'] = Yii::$app->db->createCommand($profit_sql)
            ->bindValue(':from', $from)
            ->bindValue(':to', $to)
            ->queryAll();

        $result['total'] = [
            'rasxod' => array_sum(array_column($result['rasxod'], 'summa')),
            'prixod' => array_sum(array_column($result['prixod'], 'summa')),
            'profit' => array_sum(array_column($result['profit'], 'summa')),
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
        ";

        $result['kassa'] = Yii::$app->db->createCommand($kassa_sql)
            ->bindValue(':from', $from)
            ->bindValue(':to', $to)
            ->queryAll();

        $result['kassa_total'] = [
            'kassa_kirim' => array_sum(array_column($result['kassa'], 'kirim_summa')),
            'kassa_chiqim' => array_sum(array_column($result['kassa'], 'chiqim_summa')),
        ];

        return $result;
    }

}