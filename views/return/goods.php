<?php

use app\assets\AppAsset;
use app\models\Client;
use app\models\Currency;
use app\models\Goods;
use app\models\Prixod;
use app\models\PrixodGoods;
use app\models\Rasxod;
use kartik\select2\Select2;
use yii\bootstrap5\Modal;
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

$this->title = 'Возврат № ' . $searchModel->prixod->number . ' от ' . $searchModel->prixod->client->name;
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
                <?= $form->field($model, 'rasxod_id')->widget(Select2::className(), [
                    'data' => Rasxod::selectListNonEmpty(client_id:$model->prixod->client_id),
                    'options' => ['placeholder' => 'Выберите ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
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
            <div class="col-2">
                <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
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
                    <?= Html::a("<i class='fas fa-arrow-up white_text'></i>", ['/return/index'], ['class' => 'btn btn-primary']) ?>
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
                'value' => function($model){
                    return pul2($model->amount,2);
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'cost',
                'value' => function($model){
                    return pul2($model->cost,2);
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
                'value' => function ($model) {

                    return Html::a(
                        '<i class="fas fa-check-circle"> Расходы</i>',
                        \Yii::$app->getUrlManager()->createUrl(
                            array('rasxod/by-goods', 'RasxodGoodsSearch[prixod_goods_id]' => $model['id'])
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
                        /** @var $model PrixodGoods*/
                        $url = Url::to(['/prixod-goods/update', 'id' => $model->id]);
                        if ($model->prixod->type = Prixod::TYPE_RETURN)
                            $url = Url::to(['/prixod-goods/update-return', 'id' => $model->id]);
                        return Html::a(
                            ' <span class="fas fa-edit"> </span> ',
                            $url
                        );
                    },

                    'delete' => function ($url, $model) {

                        /** @var $model PrixodGoods */
                        $url = Url::to(['/prixod-goods/delete', 'id' => $model->id]);
                        if ($model->rasxodGoods) {
                            return Html::a('<span class="fas fa-trash"></span>',
                                $url,
                                [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'onclick' => 'alert("Эта запись используется и её нельзя удалить!"); return false;'
                                ]);
                        }

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
