<?php

use app\assets\AppAsset;
use app\models\Client;
use app\models\Warehouse;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Movement $model */
/** @var yii\widgets\ActiveForm $form */
AppAsset::register($this);
?>

<div class="movement-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row d-block">
        <div class="col-4">
            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'type' => 3,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy',
                ]
            ]); ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'sender_id')->widget(Select2::className(), [
                'data' => Client::selectList(),
                'options' => ['placeholder' => 'Выберите клиент ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>

        <div class="col-4">
            <?= $form->field($model, 'recipient_id')->widget(Select2::className(), [
                'data' => Client::selectList(),
                'options' => ['placeholder' => 'Выберите клиент ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'comment')->textarea(['maxlength' => true, 'rows' => 2]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'warehouse_id')->widget(Select2::className(),[
                'data' => Warehouse::selectList(),
                'options' => ['placeholder' => 'Выберите склад ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
