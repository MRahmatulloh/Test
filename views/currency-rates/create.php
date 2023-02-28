<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Kurs $model */

$this->title = 'Новый курс валюты';
$this->params['breadcrumbs'][] = ['label' => 'Kurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kurs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
