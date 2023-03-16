<?php

use app\assets\AppAsset;
use app\models\Category;
use app\models\Goods;
use app\models\Warehouse;
use kartik\select2\Select2;
use yii\bootstrap5\Modal;
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
        'layout' => '{summary}' . Html::activeDropDownList($searchModel, 'myPageSize', [20 => 20, 50 => 50, 100 => 100, 300 => 300, 500 => 500], ['id' => 'myPageSize']) . "{items}<br/>{pager}",
        'filterModel' => $searchModel,
        'filterSelector' => '#myPageSize',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Товар',
                'attribute' => 'goods_id',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data['goods_code'] . ' - ' . $data['goods_name'], '#', [
                        'title' => 'Просмотр товара',
                        'data-url' => '/img/goods/' . $data['goods_img'],
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

<?php
Modal::begin([
    'title' => 'Фото товара',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent' style='width: min-content!important;'><img src='' alt='Нет фото товара' id='image' width='500px'></div>";
Modal::end();
?>

<?php

$js = <<<JS

    $(document).on('click', '.modalButton', function() {
        $('#image').attr('src', $(this).data('url'));
        
        $('#modal').modal('show');
    });

JS;

$this->registerJs($js);
?>
