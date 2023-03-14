<?php

use app\models\Client;
use app\models\Currency;
use app\modules\cash\models\PaymentReason;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\cash\models\Payment $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row d-block">
        <div class="col-4">
            <?=  $form->field($model, 'date')->widget(DatePicker::classname(), [
                'type' => 3,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy',
                ]
            ]); ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'client_id')->widget(Select2::className(),[
                'data' => Client::selectList(),
                'options' => ['placeholder' => 'Выберите клиент ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'summa')->textInput(['maxlength' => true]) ?>
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
            <?= $form->field($model, 'payment_type_id')->widget(Select2::className(),[
                'data' => $model::PAYMENT_TYPES,
                'options' => ['placeholder' => 'Выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'reason_id')->widget(Select2::className(),[
                'data' => PaymentReason::selectList(['type_id' => PaymentReason::TYPE_INCOME]),
                'options' => ['placeholder' => 'Выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'comment')->textarea(['maxlength' => true, 'rows' => 2]) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
