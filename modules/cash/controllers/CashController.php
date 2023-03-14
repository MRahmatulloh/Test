<?php

namespace app\modules\cash\controllers;

use app\modules\cash\models\search\CashSearch;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `cash` module
 */
class CashController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CashSearch([
            'from' => date('01.m.Y'),
            'to' => date('d.m.Y'),
            'myPageSize' => 100,
        ]);

        $stats = [
            'prixod' => [
                'sum' => 0,
                'usd' => 0,
            ],
            'rasxod' => [
                'sum' => 0,
                'usd' => 0,
            ],
        ];

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $data = $dataProvider->getModels();
        foreach ($data as $item) {
            if ($item['type'] == 'payment') {
                if ($item['currency_code'] == 860)
                    $stats['prixod']['sum'] += $item['summa'];

                if ($item['currency_code'] == 840)
                    $stats['prixod']['usd'] += $item['summa'];
            } else {
                if ($item['currency_code'] == 860)
                    $stats['rasxod']['sum'] += $item['summa'];

                if ($item['currency_code'] == 840)
                    $stats['rasxod']['usd'] += $item['summa'];
            }
        }

        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'stats' => $stats,
        ]);
    }
}
