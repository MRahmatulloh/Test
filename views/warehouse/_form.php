<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Warehouse $model */
/** @var yii\widgets\ActiveForm $form */
AppAsset::register($this);
?>
<div class="warehouse-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row d-block">
        <div class="col-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <div class="form-group">
                <h6> </h6>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

            </div>
        </div>
    </div>    <?php ActiveForm::end(); ?>

</div>
