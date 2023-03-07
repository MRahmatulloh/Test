<?php

use app\assets\AppAsset;
use app\models\Currency;
use app\models\Goods;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MovementGoods $model */
/** @var yii\widgets\ActiveForm $form */
AppAsset::register($this);
?>

<div class="movement-goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row d-block">
        <div class="col-4">
            <?= $form->field($model->movement, 'number')->textInput(['maxlength' => true, 'disabled' => true])->label('Номер перемещения') ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'goods_id')->widget(Select2::className(),[
                'data' => Goods::selectList(),
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
            <?= $form->field($model, 'cost_return')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'currency_id')->widget(Select2::className(),[
                'data' => Currency::selectList(),
                'options' => ['placeholder' => 'Выберите валюты ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-4">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
