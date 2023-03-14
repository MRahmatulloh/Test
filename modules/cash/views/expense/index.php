<?php

use app\models\Client;
use app\models\Currency;
use app\modules\cash\models\Expense;
use app\modules\cash\models\PaymentReason;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\cash\models\search\ExpenseSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Расходы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-index">

    <div class="row">
        <div class="col-6">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="col-6">
            <p class="text-right">
                <?= Html::a("<i class='fas fa-plus white_text'></i> " . ' Новое', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{summary}' . Html::activeDropDownList($searchModel, 'myPageSize', [20 => 20, 50 => 50, 100 => 100, 300 => 300, 500 => 500], ['id' => 'myPageSize']) . "{items}<br/>{pager}",
        'filterModel' => $searchModel,
        'filterSelector' => '#myPageSize',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'date',
                'value' => function (Expense $model) {
                    return Yii::$app->formatter->asDate($model->date, 'php:d.m.Y');
                },
            ],

            [
                'attribute' => 'summa',
                'value' => function (Expense $model) {
                    return pul2($model->summa, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'currency_id',
                'value' => function (Expense $model) {
                    return $model->currency->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'currency_id', Currency::selectList(), ['class' => 'form-control', 'prompt' => 'Все']),
            ],

            [
                'attribute' => 'summa_usd',
                'value' => function ($model) {
                    return pul2($model->summa_usd, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'client_id',
                'value' => function (Expense $model) {
                    return $model->client->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'client_id', Client::selectList(), ['class' => 'form-control', 'prompt' => 'Все']),
            ],

            [
                'attribute' => 'payment_type_id',
                'value' => function (Expense $model) {
                    return $model::PAYMENT_TYPES[$model->payment_type_id] ?? null;
                },
                'filter' => Expense::PAYMENT_TYPES,
            ],

            [
                'attribute' => 'reason_id',
                'value' => function (Expense $model) {
                    return $model->reason->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'reason_id', PaymentReason::selectList(['type_id' => PaymentReason::TYPE_EXPENSE]), ['class' => 'form-control', 'prompt' => 'Все']),
            ],

            [
                'attribute' => 'comment',
                'value' => function (Expense $model) {
                    return $model->comment;
                },
                'filter' => ''
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete}',
                'urlCreator' => function ($action, Expense $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
