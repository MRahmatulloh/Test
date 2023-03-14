<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\cash\models\Expense $model */

$this->title = 'Добавление расхода';
$this->params['breadcrumbs'][] = ['label' => 'Расходы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
