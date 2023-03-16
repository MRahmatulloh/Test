<?php

use app\assets\AppAsset;
use app\models\Client;
use app\models\Goods;
use app\models\PrixodGoods;
use app\models\RasxodGoods;
use kartik\select2\Select2;
use yii\bootstrap5\Modal;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\RasxodGoodsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\RasxodGoods $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Расход № ' . $searchModel->rasxod->number . ' на ' . $searchModel->rasxod->client->name;
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);

?>
<div class="prixod-goods-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{summary}' . Html::activeDropDownList($searchModel, 'myPageSize', [20 => 20, 50 => 50, 100 => 100, 300 => 300, 500 => 500], ['id' => 'myPageSize']) . "{items}<br/>{pager}",
        'filterModel' => $searchModel,
        'filterSelector' => '#myPageSize',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Партия',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var $model \app\models\RasxodGoods */
                    return \yii\helpers\Html::a(
                        '<i class="fas fa-shopping-cart"> ' . $model->prixodGoods->prixod->number . ' </i>',
                        \Yii::$app->getUrlManager()->createUrl(
                            array('prixod/goods-list', 'prixod_id' => $model->prixodGoods->prixod->id)
                        ),
                        ['class' => 'clickLock']
                    );
                },
                'contentOptions' => ['class' => 'text-center'],

            ],

            [
                'attribute' => 'goods_id',
                'format' => 'raw',
                'value' => function($model){
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
                'attribute' => 'amount',
                'value' => function ($data) {
                    return pul2($data->amount, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'cost',
                'value' => function ($data) {
                    return pul2($data->cost, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'summa',
                'value' => function ($model) {
                    return pul2($model->cost * $model->amount, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'currency_id',
                'value' => 'currency.name',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'currency_id',
                    'data' => Client::selectList(),
                    'initValueText' => $searchModel->currency_id,
                    'options' => ['placeholder' => 'Выберите ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
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

<?php
ob_start();
include "script.js";
$script = ob_get_clean();
$this->registerJs($script);
?>
