<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RasxodGoodsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="rasxod-goods-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'rasxod_id') ?>

    <?= $form->field($model, 'goods_id') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'cost_usd') ?>

    <?php // echo $form->field($model, 'currency_id') ?>

    <?php // echo $form->field($model, 'prixod_goods_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
