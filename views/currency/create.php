<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Currency $model */

$this->title = 'Новая валюта';
$this->params['breadcrumbs'][] = ['label' => 'Currencys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
