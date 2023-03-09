<?php

use app\assets\AppAsset;
use app\models\Currency;
use app\models\Goods;
use app\models\Prixod;
use app\models\PrixodGoods;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\PrixodGoodsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\PrixodGoods $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Приход № ' . $searchModel->prixod->number . ' от ' . $searchModel->prixod->client->name;
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);

?>
<div class="prixod-goods-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Фото товара',
                'format' => 'raw',
                'value' => function($model){
                    return Html::img('@web'.'/img/goods/' . $model->goods->img, ['class' => 'img-fluid', 'width' => '80px']);
                }
            ],

            [
                'attribute' => 'goods_id',
                'value' => function($data){
                    return $data->goods->code .'-'.$data->goods->name;
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
                'value' => function($data){
                    return pul2($data->amount,2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'cost',
                'value' => function($data){
                    return pul2($data->cost,2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'summa',
                'value' => function($model){
                    return pul2($model->cost * $model->amount, 2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'label' => 'Расходное к-во',
                'format' => 'raw',
                'value' => function ($data) {

                    return Html::a(
                        '<i class="fas fa-check-circle"> Расходы</i>',
                        \Yii::$app->getUrlManager()->createUrl(
                            array('rasxod/by-goods', 'RasxodGoodsSearch[prixod_goods_id]' => $data['id'])
                        ),
                        ['class' => 'clickLock']
                    );
                },
                'contentOptions' => ['class' => 'text-center'],

            ],

            [
                'attribute' => 'currency_id',
                'value' => 'currency.name',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'currency_id',
                    'data' => Currency::selectList(),
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
