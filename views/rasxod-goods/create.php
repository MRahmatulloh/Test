<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RasxodGoods $model */

$this->title = 'Create Order Goods';
$this->params['breadcrumbs'][] = ['label' => 'Order Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rasxod-goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
