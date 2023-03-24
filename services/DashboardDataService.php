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

        $kassa_kirim_sql = "
            select
                round(ifnull(sum(p.summa_usd), 0), 2) as summa,
                p.date
            from payment p
            where p.date between :from and :to
            group by p.date";

        $kassa_chiqim_sql = "
            select
                round(ifnull(sum(e.summa_usd), 0), 2) as summa,
                e.date
            from expense e
            where e.date between :from and :to
            group by e.date";

        $result['kassa_kirim'] = Yii::$app->db->createCommand($kassa_kirim_sql)
            ->bindValue(':from', $from)
            ->bindValue(':to', $to)
            ->queryAll();

        $result['kassa_chiqim'] = Yii::$app->db->createCommand($kassa_chiqim_sql)
            ->bindValue(':from', $from)
            ->bindValue(':to', $to)
            ->queryAll();

        $result['kassa_total'] = [
            'kassa_kirim' => array_sum(array_column($result['kassa_kirim'], 'summa')),
            'kassa_chiqim' => array_sum(array_column($result['kassa_chiqim'], 'summa')),
        ];


        return $result;
    }

}