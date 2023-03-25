<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\cash\models\PaymentReason $model */
/** @var yii\widgets\ActiveForm $form */
?>
<style>
    .modal-body {
        margin: 0!important;
    }
</style>

<div class="payment-reason-form w-100">

    <?php $form = ActiveForm::begin(); ?>


            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'type_id')->widget(Select2::className(), [
                'data' => $model::TYPES,
                'options' => ['placeholder' => 'Выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

            <div class="form-group">
                <h6> </h6>
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
            </div>


    <?php ActiveForm::end(); ?>

</div>
