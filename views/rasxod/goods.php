<?php

use app\assets\AppAsset;
use app\models\PrixodGoods;
use kartik\select2\Select2;
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
    <div class="prixod-goods-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-2">
                <?= $form->field($model, 'prixod_id')->widget(Select2::className(), [
                    'data' => \app\models\Prixod::selectListNonEmpty($model->rasxod->warehouse_id),
                    'options' => ['placeholder' => 'Выберите ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-2">
                <?= $form->field($model, 'prixod_goods_id')->widget(Select2::className(), [
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
            <div class="col-2">
                <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'currency_id')->widget(Select2::className(), [
                    'data' => \app\models\Currency::selectList(),
                    'options' => ['placeholder' => 'Выберите валюты ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-2">
                <h6> </h6>
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                <?= Html::a("<i class='fas fa-arrow-up white_text'></i>", ['/rasxod/index'], ['class' => 'btn btn-primary']) ?>
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
                'label' => 'Фото товара',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var $model \app\models\RasxodGoods */
                    return Html::img('@web' . '/img/goods/' . $model->goods->img, ['class' => 'img-fluid', 'width' => '80px']);
                }
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

            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete}',
                'buttons' => [

                    'update' => function ($url, $model) {
                        $url = Url::to(['/rasxod-goods/update', 'id' => $model->id]);
                        return Html::a(
                            ' <span class="fas fa-edit"> </span> ',
                            $url
                        );
                    },

                    'delete' => function ($url, $model) {
                        /** @var $model PrixodGoods */
                        $url = Url::to(['/rasxod-goods/delete', 'id' => $model->id]);

                        return Html::a(
                            '<span class="fas fa-trash"></span>',
                            $url,
                            [
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Вы уверены, что хотите удалить этот элемент?'),
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
