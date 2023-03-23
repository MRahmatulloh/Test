<?php

use app\assets\AppAsset;
use app\models\Goods;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Pricelist $model */
/** @var yii\widgets\ActiveForm $form */
AppAsset::register($this);
?>

<div class="pricelist-form">

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
        <div class="col-md-4">
            <?= $form->field($model, 'goods_id')->widget(Select2::className(), [
                'data' => Goods::selectList(),
                'options' => ['placeholder' => 'Выберите товар ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'price_full')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'price_transfer')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'price_credit')->textInput(['maxlength' => true]) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
