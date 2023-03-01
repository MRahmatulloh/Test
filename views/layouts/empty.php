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
    <title>Management Admin</title>
    <link rel="icon" href=<?= Yii::getAlias('@web')?>"/img/mini_logo.png" type="image/png">
</head>
<body class="vh-100" style="background-image: url(<?= Yii::$app->request->baseUrl . '/img/bg.jpg'; ?>); background-size: cover; background-repeat: no-repeat">
<?php $this->beginBody() ?>
<<<<<<< HEAD

    <?php echo $content; ?>

=======
<div class="row vh-100 mt-auto">
    <div class="col-10 col-md-3 m-auto px-5" style="border-radius: 5px; background-color: rgba(1,1,1, .75)">
        <?php echo $content; ?>
    </div>
</div>
>>>>>>> 8025d34 (conf)
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
