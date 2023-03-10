<?php

// comment out the following two lines when deployed to production
 defined('YII_DEBUG') or define('YII_DEBUG', true);
 defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require(__DIR__ . '/../components/globals.php');

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config));

Yii::$container->set('yii\widgets\LinkPager', 'yii\bootstrap5\LinkPager');

Yii::$app->run();  
