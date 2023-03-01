<?php

use app\assets\AppAsset;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Rasxod $model */
/** @var yii\widgets\ActiveForm $form */

AppAsset::register($this);
?>

<div class="rasxod-form">
    <br>
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
            <?= $form->field($model, 'client_id')->widget(\kartik\select2\Select2::className(),[
                'data' => \app\models\Client::selectList(),
                'options' => ['placeholder' => 'Выберите клиент ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'type')->widget(\kartik\select2\Select2::className(),[
                'data' => $model::TYPES,
                'options' => ['placeholder' => 'Выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'comment')->textarea(['maxlength' => true, 'rows' => 1]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'warehouse_id')->widget(\kartik\select2\Select2::className(),[
                'data' => \app\models\Warehouse::selectList(),
                'options' => ['placeholder' => 'Выберите склад ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-3"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>