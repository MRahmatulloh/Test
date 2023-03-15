<?php

use app\models\Currency;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CurrencyRates $model */

$this->title = 'Обновление: ' . Currency::selectListByCode()[$model->code] .' на '. dateView($model->date);
$this->params['breadcrumbs'][] = ['label' => 'Kurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kurs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
