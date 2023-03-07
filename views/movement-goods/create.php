<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MovementGoods $model */

$this->title = 'Create Movement Goods';
$this->params['breadcrumbs'][] = ['label' => 'Movement Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movement-goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
