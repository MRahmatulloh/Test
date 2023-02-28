<?php

use app\assets\AppAsset;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\PrixodGoodsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\PrixodGoods $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Приход по товаром ';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);

?>
<div class="prixod-goods-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <br>
    <div class="prixod-goods-form">

        <?php $form = ActiveForm::begin(['method' => 'get']); ?>

        <div class="row">
            <div class="col-3">
                <?= $form->field($model, 'date1')->widget(DatePicker::classname(), [
                    'type' => 3,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy',
                    ]
                ]); ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'date2')->widget(DatePicker::classname(), [
                    'type' => 3,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy',
                    ]
                ]); ?>
            </div>

            <div class="col-3">
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
//                'attribute' => 'date',
                'value' => function ($data) {
                    return dateView($data->prixod->date);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
//                'attribute' => 'number',
                'format' => 'raw',
                'value' => function ($data) {

                    return \yii\helpers\Html::a(
                        $data->prixod->number,
                        \Yii::$app->getUrlManager()->createUrl(
                            array('prixod/goods-list', 'id' => $data->prixod->id)
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
                    'data' => \app\models\Client::selectList(),
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
