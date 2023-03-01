<?php

use app\assets\AppAsset;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Kurs $model */
/** @var yii\widgets\ActiveForm $form */
AppAsset::register($this);
?>

<div class="kurs-form">

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
            <?= $form->field($model, 'code')->widget(\kartik\select2\Select2::className(),[
                'data' => \app\models\Currency::selectListByCode(),
                'options' => ['placeholder' => 'Выберите валюты ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Валюта') ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'rate')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <div class="form-group">
                <h6> </h6>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
