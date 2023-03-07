<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Prixod $model */

$this->title = 'Новое приходное требование';
$this->params['breadcrumbs'][] = ['label' => 'Приход', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prixod-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
