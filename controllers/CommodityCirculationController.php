<?php

namespace app\controllers;

use yii\web\Controller;

class CommodityCirculationController extends Controller
{
    public $dateFrom;
    public $dateTo;
    public $client_id;

    public function actionIndex($client_id = null, $dateFrom = null, $dateTo = null)
    {
        $this->dateFrom = $this->request->get('dateFrom');
        $this->dateTo = $this->request->get('dateTo');
        $this->client_id = $this->request->get('client_id');

        $this->render('index',[
            'client_id' => $this->client_id,
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
        ]);
    }

}