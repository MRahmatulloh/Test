<?php

use app\models\Client;
use app\models\Currency;
use app\modules\cash\models\Payment;
use app\modules\cash\models\PaymentReason;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\cash\models\search\PaymentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Платежи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

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
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'date',
                'value' => function (Payment $model) {
                    return Yii::$app->formatter->asDate($model->date, 'php:d.m.Y');
                },
            ],

            [
                'attribute' => 'summa',
                'value' => function($model){
                    return pul2($model->summa, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'summa_usd',
                'value' => function($model){
                    return pul2($model->summa_usd, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

                [
                    'attribute' => 'currency_id',
                    'value' => function (Payment $model) {
                        return $model->currency->name;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'currency_id', Currency::selectList(), ['class' => 'form-control', 'prompt' => 'Все']),
                ],

                [
                    'attribute' => 'client_id',
                    'value' => function (Payment $model) {
                        return $model->client->name;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'client_id', Client::selectList(), ['class' => 'form-control', 'prompt' => 'Все']),
                ],

                [
                    'attribute' => 'payment_type_id',
                    'value' => function (Payment $model) {
                        return $model::PAYMENT_TYPES[$model->payment_type_id] ?? null;
                    },
                    'filter' => [],
                ],

                [
                    'attribute' => 'reason_id',
                    'value' => function (Payment $model) {
                        return $model->reason->name;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'reason_id', PaymentReason::selectList(['type_id' => PaymentReason::TYPE_INCOME]), ['class' => 'form-control', 'prompt' => 'Все']),
                ],

                [
                    'attribute' => 'comment',
                    'value' => function (Payment $model) {
                        return $model->comment;
                    },
                    'filter' => ''
                ],

//            'currency_id',
            //'client_id',
            //'payment_type_id',
            //'reason_id',
            //'comment',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Payment $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
