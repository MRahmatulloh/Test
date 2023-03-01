<?php

use app\assets\AppAsset;
use app\models\Goods;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RasxodGoods $model */
/** @var yii\widgets\ActiveForm $form */
AppAsset::register($this);
?>

<div class="rasxod-goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row d-block">
        <div class="col-4">
            <?= $form->field($model, 'goods_id')->widget(Select2::className(), [
                'data' => Goods::selectList(['id' => $model->goods_id]),
                'options' => ['placeholder' => 'Выберите товар ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'currency_id')->widget(Select2::className(), [
                'data' => \app\models\Currency::selectList(),
                'options' => ['placeholder' => 'Выберите валюты ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-4">
            <h6> </h6>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
