<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\cash\models\PaymentReason $model */

$this->title = 'Назначение платежа';
$this->params['breadcrumbs'][] = ['label' => 'Причины оплаты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-reason-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
