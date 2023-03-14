<?php

/** @var yii\web\View $this */
/** @var app\modules\cash\models\PaymentReason $model */

$this->title = 'Обновление записи: ' .'<br>'. $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Причины оплаты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payment-reason-update">

    <h1><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
