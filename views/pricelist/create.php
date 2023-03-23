<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pricelist $model */

$this->title = 'Новый прайс';
$this->params['breadcrumbs'][] = ['label' => 'Pricelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pricelist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
