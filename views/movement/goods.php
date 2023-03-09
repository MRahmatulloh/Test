<?php

use app\assets\AppAsset;
use app\models\Client;
use app\models\Currency;
use app\models\Goods;
use app\models\Movement;
use app\models\MovementGoods;
use app\models\Rasxod;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\MovementGoodsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\MovementGoods $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Перемещение № ' . $searchModel->movement->number . ' от ' . $searchModel->movement->sender->name . ' к ' . $searchModel->movement->recipient->name;
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);

?>
<div class="prixod-goods-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <br>
    <div class="prixod-goods-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-2">
                <?= $form->field($model->movement, 'rasxod_id')->widget(Select2::className(), [
                    'data' => Rasxod::selectListNonEmpty(null, $model->movement->sender_id),
                    'options' => ['placeholder' => 'Выберите ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
                <input type="hidden" id="movement_id" class="d-none" value="<?= $model->movement_id ?>">
            </div>
            <div class="col-2">
                <?= $form->field($model, 'rasxod_goods_id')->widget(Select2::className(), [
                    'data' => [],
                    'options' => ['placeholder' => 'Выберите товар ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-1">
                <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-1">
                <?= $form->field($model, 'cost_return')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-2">
                <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'currency_id')->widget(Select2::className(),[
                    'data' => Currency::selectList(),
                    'options' => ['placeholder' => 'Выберите валюты ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-2">
                    <h6> </h6>
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                    <?= Html::a("<i class='fas fa-arrow-up white_text'></i>", ['index'], ['class' => 'btn btn-primary']) ?>
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
                'label' => 'Фото товара',
                'format' => 'raw',
                'value' => function($model){
                    return Html::img('@web'.'/img/goods/' . $model->goods->img, ['class' => 'img-fluid', 'width' => '80px']);
                }
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

            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete}',
                'buttons' => [

                    'update' => function ($url, $model) {
                        /** @var $model MovementGoods*/
                        $url = Url::to(['/movement-goods/update', 'id' => $model->id]);
                        if ($model->movement->status == Movement::STATUS_NEW)
                        return Html::a(
                            ' <span class="fas fa-edit"> </span> ',
                            $url
                        );
                    },

                    'delete' => function ($url, $model) {
                        /** @var $model MovementGoods*/
                        $url = Url::to(['/movement-goods/delete', 'id' => $model->id]);
                        if ($model->movement->status == Movement::STATUS_NEW)
                        return Html::a(
                            ' <span class="fas fa-trash"> </span> ',
                            $url,
                            [
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>

<?php
ob_start();
include "script.js";
$script = ob_get_clean();
$this->registerJs($script);
?>
