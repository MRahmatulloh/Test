<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Currency $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="currency-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'code')->textInput() ?>
        </div>
        <div class="col-3">
            <div class="form-group">
                <h6> </h6>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>







    <?php ActiveForm::end(); ?>

</div>
