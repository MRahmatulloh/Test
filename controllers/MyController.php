<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;

class MyController extends \yii\web\Controller
{
    public function beforeAction( $action ) {
        if ( parent::beforeAction ( $action ) ) {

            //change layout for error action after
            //checking for the error action name
            //so that the layout is set for errors only
            if ( $action->id == 'error' ) {
                $this->layout = 'other';
            }
            return true;
        }
        return false;
    }
}