<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Client $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row d-block">
        <div class="col-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'address')->textInput() ?>
        </div>
        <div class="col-4">
             <?= $form->field($model, 'tel')->widget(\yii\widgets\MaskedInput::class, [
                 'mask' => '99-999-99-99',
             ]) ?>
        </div>
        <div class="col-4">
            <div class="form-group">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
