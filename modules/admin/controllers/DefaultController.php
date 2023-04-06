<?php

namespace mdm\admin\controllers;

use app\controllers\MyController;
use Yii;

/**
 * DefaultController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class DefaultController extends MyController
{

    /**
     * Action index
     */
    public function actionIndex($page = 'README.md')
    {
        if (preg_match('/^docs\/images\/image\d+\.png$/',$page)) {
            $file = Yii::getAlias("@mdm/admin/{$page}");
            return Yii::$app->getResponse()->sendFile($file);
        }
        return $this->render('index', ['page' => $page]);
    }
}
