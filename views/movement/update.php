<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Movement $model */

$this->title = 'Обновление перемещение: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Перемещение', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="movement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
