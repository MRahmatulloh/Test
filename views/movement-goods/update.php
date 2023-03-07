<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MovementGoods $model */

$this->title = 'Update Movement Goods: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Movement Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="movement-goods-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
