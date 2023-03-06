<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Prixod $model */

$this->title = 'Обновить требование № ' . $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Prixods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prixod-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'update' => true
    ]) ?>

</div>
