<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PrixodGoods $model */

$this->title = 'Create Prixod Goods';
$this->params['breadcrumbs'][] = ['label' => 'Prixod Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prixod-goods-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
