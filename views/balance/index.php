<?php

use app\assets\AppAsset;
use app\models\Category;
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

$this->title = 'Текущий остаток на ' . date('d.m.Y');
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
?>
<div class="category-index">

    <div class="row">
        <div class="col-6">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="col-6">
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Фото товара',
                'format' => 'raw',
                'value' => function($data){
                    return Html::img('@web'.'/img/goods/' . $data['goods_img'], ['class' => 'img-fluid', 'width' => '80px']);
                }
            ],

            [
                'label' => 'Товар',
                'attribute' => 'goods_id',
                'value' => function ($data) {
                    return $data['goods_code'] . ' - ' . $data['goods_name'];
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'goods_id',
                    'data' => Goods::selectList(),
                    'initValueText' => $searchModel->goods_id,
                    'options' => ['placeholder' => 'Выберите товар ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],

            [
                'label' => 'Приход',
                'attribute' => 'in_amount',
                'value' => function ($data) {
                    return pul2($data['in_amount'], 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'label' => 'Расход',
                'attribute' => 'out_amount',
                'value' => function ($data) {
                    return pul2($data['out_amount'], 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'label' => 'Остаток',
                'attribute' => 'ostatok',
                'value' => function ($data) {
                    return pul2($data['ostatok'], 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'label' => 'Склад',
                'attribute' => 'warehouse_id',
                'value' => function ($data) {
                    return $data['warehouse_name'] ?? 'Все';
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'warehouse_id',
                    'data' => ['Все'] + Warehouse::selectList(),
                    'initValueText' => $searchModel->warehouse_id ?? 'Все',
                    'options' => ['placeholder' => 'Выберите ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ]
        ],
    ]); ?>

</div>
