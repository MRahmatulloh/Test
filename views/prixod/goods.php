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
    <div class="prixod-goods-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'goods_id')->widget(Select2::className(),[
                    'data' => Goods::selectList(),
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
            <div class="col-md-3">
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
                    <?= Html::a("<i class='fas fa-arrow-up white_text'></i>", ['/prixod/index'], ['class' => 'btn btn-primary']) ?>
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
                'label' => 'Фото товара',
                'format' => 'raw',
                'value' => function($model){
                    return Html::img('@web'.'/img/goods/' . $model->goods->img, ['class' => 'img-fluid', 'width' => '80px']);
                }
            ],

            [
                'attribute' => 'goods_id',
                'value' => function($model){
                    return $model->goods->code .'-'.$model->goods->name;
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
                    'data' => Currency::selectList(),
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
                        if ($model->prixod->type == Prixod::TYPE_RETURN)
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
