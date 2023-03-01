<?php

/** @var yii\web\View $this */
/** @var app\models\RasxodGoods $model */

$this->title = 'Обновление записи расходного товара';
$this->params['breadcrumbs'][] = ['label' => 'Расход', 'url' => ['/rasxod/goods-list', 'rasxod_id' => $model->rasxod_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rasxod-goods-update">

    <h3><?=  $this->title . ': <br> ' . $model->goods->code . '-' . $model->goods->name . ' из ' . $model->rasxod->number; ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
