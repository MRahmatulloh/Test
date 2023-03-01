<?php

use app\assets\AppAsset;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Goods $model */

$this->title = 'Добавление нового товара';
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
?>
<div class="goods-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
