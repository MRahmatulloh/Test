<?php

namespace app\controllers;

use app\services\DashboardDataService;
use yii\web\Controller;

class DashboardController extends Controller
{
    /**
     * @var DashboardDataService
     */
    private $dashboardDataService;

    public function __construct($id, $module, DashboardDataService $dashboardDataService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->dashboardDataService = $dashboardDataService;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($from = null, $to = null)
    {
        $from = $from ?: date('Y-m-01');
        $to = $to ?: date('Y-m-d');

        $data = $this->dashboardDataService->getData($from, $to);

        return $this->render('index', [
            'from' => $from,
            'to' => $to,
            'data' => $data,
        ]);
    }
}
