<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <title>Easy Contract System</title>
    <link rel="icon" href=<?= Yii::getAlias('@web')?>"/img/mini_logo.png" type="image/png">
    <style>
        .row{
            --bs-gutter-x: 0rem!important;
        }
    </style>
</head>
<body class="" style="background-image: url(<?= Yii::$app->request->baseUrl . '/img/bg.jpg'; ?>); background-size: cover; background-repeat: no-repeat">
<?php $this->beginBody() ?>
<div class="row vh-100 mt-auto">
    <div class="col-12 col-sm-6 col-md-6 col-lg-3 m-auto px-5" style="border-radius: 5px; background-color: rgba(1,1,1, .75)">
        <?php echo $content; ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
