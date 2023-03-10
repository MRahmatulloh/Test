<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Movement $model */

$this->title = 'Новое перемещение';
$this->params['breadcrumbs'][] = ['label' => 'Перемещение', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
