<?php

use app\assets\AppAsset;
use app\models\Category;
use app\models\Client;
use app\models\Goods;
use app\models\Warehouse;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\BalanceSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var string $client_id */
/** @var string $stats */
/** @var string $type */
/** @var string $from */
/** @var string $to */

$this->title = 'Текущий долг на ' . dateView($from) . ' - ' . dateView($to);
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
?>
<div class="category-index">

    <div class="row">
        <div class="col-8">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="col-4">
            <table class="table">
                <tbody>
                <tr>
                    <th>Приход($)</th>
                    <th>Расход($)</th>
                    <th>Итог($)</th>
                </tr>
                <tr>
                    <td><?= pul2($stats['prixod'] ?? 0, 2) ?></td>
                    <td><?= pul2($stats['rasxod'] ?? 0, 2) ?></td>
                    <td><?= pul2(($stats['prixod'] ?? 0) - ($stats['rasxod'] ?? 0), 2) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <form action="" method="get" style="margin-bottom: 20px;">
        <div class="row">
            <div class="col-md-2">
                <?= Html::label(Yii::t('app', 'Дата «С»'), 'from') ?>
                <?= Html::input('date', 'from', $from, [
                    'class' => 'form-control',
                ]) ?>
            </div>
            <div class="col-md-2 mx-3">
                <?= Html::label(Yii::t('app', '«По»'), 'to') ?>
                <?= Html::input('date', 'to', $to, [
                    'class' => 'form-control',
                ]) ?>
            </div>

            <div class="col-md-2">
                <?= Html::label(Yii::t('app', 'Клиент'), 'client') ?>
                <?= Select2::widget([
                    'name' => 'client_id',
                    'value' => $client_id,
                    'data' => Client::selectList(),
                    'options' => [
                        'placeholder' => Yii::t('app', 'Выберите клиента'),
                        'class' => 'form-control',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>

            <div class="col-md-2">
                <?= Html::label(Yii::t('app', 'Тип операции'), 'type') ?>
                <?= Select2::widget([
                    'name' => 'type',
                    'value' => $type,
                    'data' => [
                        'product-in' => 'Приход товара',
                        'product-out' => 'Расход товара',
                        'money-in' => 'Приход денег',
                        'money-out' => 'Расход денег'
                    ],
                    'options' => [
                        'placeholder' => Yii::t('app', 'Выберите тип операции'),
                        'class' => 'form-control',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>

            <div class="col-md-1">
                <label>&nbsp;</label>
                <button class="btn btn-primary form-control" type="submit"><?= Yii::t('app', 'Поиск') ?></button>
            </div>
        </div>

    </form>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{summary}' . Html::activeDropDownList($searchModel, 'myPageSize', [20 => 20, 50 => 50, 100 => 100, 300 => 300, 500 => 500], ['id' => 'myPageSize']) . "{items}<br/>{pager}",
        'filterModel' => $searchModel,
        'filterSelector' => '#myPageSize',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Дата',
                'value' => function ($data) {
                    return dateView($data['date']);
                }
            ],

            [
                'label' => 'Клиент',
                'value' => function ($data) {
                    return $data['client_name'];
                }
            ],

            [
                'label' => 'Приход',
                'value' => function ($data) {

                    if ($data['type'] == 'product-in' or $data['type'] == 'money-in')
                        return pul2($data['summa'], 2);

                    return '';
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'label' => 'Расход',
                'value' => function ($data) {
                    if ($data['type'] == 'product-out' or $data['type'] == 'money-out')
                        return pul2($data['summa'], 2);

                    return '';
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'label' => 'Тип операции',
                'value' => function ($data) {
                    if ($data['type'] == 'product-out')
                        return 'Расход товара';

                    if ($data['type'] == 'product-in')
                        return 'Приход товара';

                    if ($data['type'] == 'money-out')
                        return 'Расход денег';

                    if ($data['type'] == 'money-in')
                        return 'Приход денег';

                    return '';
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {

                        if($model['type'] == 'product-in')
                            $url = Url::to(['prixod/goods-list', 'prixod_id' => $model['id']]);

                        if($model['type'] == 'product-out')
                            $url = Url::to(['rasxod/goods-list', 'rasxod_id' => $model['id']]);

                        if($model['type'] == 'money-in')
                            $url = Url::to(['cash/payment/index', 'PaymentSearch[id]' => $model['id']]);

                        if($model['type'] == 'money-out')
                            $url = Url::to(['cash/expense/index', 'ExpenseSearch[id]' => $model['id']]);

                        return Html::a('<span class="fas fa-eye"></span>', $url, [
                            'title' => Yii::t('app', 'View'),
                        ]);
                    },
                ],
            ]


        ],
    ]); ?>

</div>
