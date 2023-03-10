<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\cash\models\Payment $model */

$this->title = 'Create Payment';
$this->params['breadcrumbs'][] = ['label' => 'Платежи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
