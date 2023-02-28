<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Warehouse $model */

$this->title = 'Добавление нового склада';
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
