<?php

use app\assets\AppAsset;
use app\models\Currency;
use app\models\Goods;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\RasxodGoodsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\search\Filter $searchModel */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Расход по товаром ';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);

?>
<div class="rasxod-goods-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <div class="rasxod-goods-form">

        <?php $form = ActiveForm::begin(['method' => 'get']); ?>

        <div class="row">
            <div class="col-md-3">
                <?= $form->field($searchModel, 'from')->widget(DatePicker::classname(), [
                    'type' => 3,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy',
                    ]
                ]); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'to')->widget(DatePicker::classname(), [
                    'type' => 3,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy',
                    ]
                ]); ?>
            </div>

            <div class="col-md-3">
                <h6> </h6>
                <?= Html::submitButton('Показать', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Дата',
                'value' => function ($data) {
                    return dateView($data->rasxod->date);
                },
                'filter' => ''
            ],

            [
                'attribute' => 'client_name',
                'value' => function ($data) {
                    return $data->rasxod->client->name;
                },
            ],

            [
                'label' => 'Расход',
                'format' => 'raw',
                'value' => function ($data) {

                    return Html::a(
                        $data->rasxod->number,
                        \Yii::$app->getUrlManager()->createUrl(
                            array('rasxod/goods-list', 'rasxod_id' => $data->rasxod->id)
                        )
                    );
                },
            ],

            [
                'attribute' => 'goods_id',
                'value' => function ($data) {
                    return $data->goods->code . '-' . $data->goods->name;
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
                'value' => function ($searchModel) {
                    return pul2($searchModel->cost * $searchModel->amount, 2);
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
