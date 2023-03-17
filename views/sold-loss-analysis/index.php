<?php

use app\assets\AppAsset;
use app\models\Category;
use app\models\Client;
use app\models\Goods;
use app\models\RasxodGoods;
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
/** @var string $from */
/** @var string $to */

$this->title = 'Продано с убытком за период ' . dateView($from) . ' - ' . dateView($to);
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
?>
<div class="category-index">

    <div class="row">
        <div class="col-8">
            <h2><?= Html::encode($this->title) ?></h2>
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
                'value' => function (RasxodGoods $model) {
                    return dateView($model->rasxod->date);
                }
            ],

            [
                'label' => 'Клиент',
                'value' => function (RasxodGoods $model) {
                    return $model->rasxod->client->name;
                }
            ],

            [
                'label' => 'Партия',
                'format' => 'raw',
                'value' => function (RasxodGoods $model) {
                    return Html::a(
                        '<i class="fas fa-shopping-cart"> ' . $model->rasxod->number . ' </i>',
                        \Yii::$app->getUrlManager()->createUrl(
                            array('rasxod/goods-list', 'rasxod_id' => $model->rasxod->id)
                        )
                    );
                },
                'contentOptions' => ['class' => 'text-center'],
            ],

            [
                'attribute' => 'goods_id',
                'label' => 'Товар',
                'format' => 'raw',
                'value' => function(RasxodGoods $model){
                    return Html::a($model->goods->code .'-'.$model->goods->name, '#', [
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
                'label' => 'Цена продажи ($)',
                'value' => function (RasxodGoods $model) {
                    return pul2($model->cost_usd, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'label' => 'Себестоимость ($)',
                'value' => function (RasxodGoods $model) {
                    return pul2($model->prixodGoods->cost_usd, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'label' => 'Кол-во',
                'value' => function (RasxodGoods $model) {
                    return pul2($model->amount, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'label' => 'Убыток ($)',
                'value' => function (RasxodGoods $model) {
                    return pul2($model->amount * ($model->cost_usd - $model->prixodGoods->cost_usd), 2);
                },
                'contentOptions' => ['class' => 'text-right bg-danger text-white'],
                'filter' => ''
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
