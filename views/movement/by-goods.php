<?php

use app\assets\AppAsset;
use app\models\Currency;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\MovementGoodsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Перемещение по товаром ';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);

?>
<div class="movement-goods-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <div class="movement-goods-form">

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
        'layout' => '{summary}' . Html::activeDropDownList($searchModel, 'myPageSize', [20 => 20, 50 => 50, 100 => 100, 300 => 300, 500 => 500], ['id' => 'myPageSize']) . "{items}<br/>{pager}",
        'filterModel' => $searchModel,
        'filterSelector' => '#myPageSize',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Дата',
                'value' => function ($data) {
                    return dateView($data->movement->date);
                },
                'filter' => ''
            ],

//            [
//                'label' => 'Клиент',
//                'attribute' => 'client_name',
//                'value' => function ($data) {
//                    return $data->movement->client->name;
//                },
//            ],

            [
                'label' => 'Перемещение',
                'format' => 'raw',
                'value' => function ($data) {

                    return Html::a(
                        $data->movement->number,
                        \Yii::$app->getUrlManager()->createUrl(
                            array('movement/goods-list', 'id' => $data->movement->id)
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
                    'data' => \app\models\Goods::selectList(),
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

            [
                'label' => 'Склад',
                'value' => function ($data) {
                    return $data->movement->warehouse->name;
                },
            ],
        ],
    ]); ?>


</div>
