<?php

use app\models\Client;
use app\models\Currency;
use app\modules\cash\models\PaymentReason;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\cash\models\Expense $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="expense-form">

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
            <div class="row">
                <div class="col-10">
                    <?= $form->field($model, 'reason_id')->widget(Select2::className(), [
                        'data' => PaymentReason::selectList(['type_id' => PaymentReason::TYPE_EXPENSE]),
                        'options' => ['placeholder' => 'Выберите ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'class' => 'form-control w-100',
                        ],
                    ]) ?>
                </div>
                <div class="col-2">
                    <h6> </h6>
                    <div class="input-group-append" id="modalButton">
                        <span class="input-group-text form-control bg-primary justify-content-center"> <i class='fas fa-plus'></i> </span>
                    </div>
                </div>
            </div>
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

<?php
Modal::begin([
    'title' => 'Цель платежа',
    'id' => 'modal',
    'size' => 'modal-md',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php

$js = <<<JS
    $(document).on('click', '#modalButton', function() {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('/cash/payment-reason/create-ajax');
    });
JS;

$this->registerJs($js);
?>
