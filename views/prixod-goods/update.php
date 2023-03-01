<?php

/** @var yii\web\View $this */
/** @var app\models\PrixodGoods $model */

$this->title = 'Обновление записи приходного товара';
$this->params['breadcrumbs'][] = ['label' => 'Приход', 'url' => ['/prixod/goods-list', 'prixod_id' => $model->prixod_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prixod-goods-update">

    <h3><?= $this->title . ': <br> ' . $model->goods->code . '-' . $model->goods->name . ' из ' . $model->prixod->number; ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
