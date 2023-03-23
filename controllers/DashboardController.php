<?php

namespace app\controllers;

use yii\web\Controller;

class DashboardController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($from = null, $to = null)
    {
        $from = $from ?: date('Y-m-d');
        $to = $to ?: date('Y-m-d');

        return $this->render('index', [
            'from' => $from,
            'to' => $to,
        ]);
    }
}
