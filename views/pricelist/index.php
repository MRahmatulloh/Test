<?php

use app\assets\AppAsset;
use app\models\Goods;
use app\models\Pricelist;
use kartik\select2\Select2;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PricelistSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Прайслист';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
?>
<div class="pricelist-index">

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
                'format' => ['date', 'php:d.m.Y'],
                'filter' => ''
            ],

            [
                'attribute' => 'goods_id',
                'format' => 'raw',
                'value' => function (Pricelist $model) {
                    return Html::a($model->goods->code . '-' . $model->goods->name, '#', [
                        'title' => 'Просмотр товара',
                        'data-url' => '/img/goods/' . $model->goods->img,
                        'data-pjax' => '0',
                        'class' => 'modalButton'
                    ]);
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
                'attribute' => 'price_full',
                'value' => function (Pricelist $model) {
                    return pul2($model->price_full, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'price_transfer',
                'value' => function (Pricelist $model) {
                    return pul2($model->price_transfer, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'price_credit',
                'value' => function (Pricelist $model) {
                    return pul2($model->price_credit, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete}',
                'urlCreator' => function ($action, Pricelist $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>