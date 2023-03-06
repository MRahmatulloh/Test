<?php

use app\assets\AppAsset;
use app\models\Client;
use app\models\Prixod;
use app\models\Warehouse;
use kartik\select2\Select2;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\search\PrixodSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Список приходов';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
?>
<div class="prixod-index">

    <div class="row">
        <div class="col-6">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="col-6">
            <p class="text-right">
                <?= Html::a("<i class='fas fa-plus white_text'></i> " . ' Новое', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'date',
                'value' => function ($model) {
                    return dateView($model->date);
                }
            ],

            [
                'attribute' => 'number',
                'format' => 'raw',
                'value' => function ($model) {
                    $number = $model['number'];

                    if ($model['type'] == Prixod::TYPE_RETURN) {
                        return Html::a(
                            $number,
                            \Yii::$app->getUrlManager()->createUrl(
                                array('return/goods-list', 'prixod_id' => $model['id'])
                            ),
                        );
                    }

                    return Html::a(
                        $number,
                        \Yii::$app->getUrlManager()->createUrl(
                            array('prixod/goods-list', 'prixod_id' => $model['id'])
                        ),
                    );
                },
            ],

            [
                'attribute' => 'client_id',
                'value' => 'client.name',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'client_id',
                    'data' => Client::selectList(),
                    'initValueText' => $searchModel->client_id,
                    'options' => ['placeholder' => 'Выберите клиент ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],

            'comment',

            [
                'attribute' => 'type',
                'value' => function ($model) {
                    return Prixod::TYPES[$model->type];
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'type',
                    'data' => Prixod::TYPES,
                    'initValueText' => $searchModel->type,
                    'options' => ['placeholder' => 'Выберите тип ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],

            [
                'attribute' => 'warehouse_id',
                'value' => 'warehouse.name',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'warehouse_id',
                    'data' => Warehouse::selectList(),
                    'initValueText' => $searchModel->warehouse_id,
                    'options' => ['placeholder' => 'Выберите ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{print} {update} {delete}',
                'buttons' => [

                    'print' => function ($url, $model) {
                        return Html::a(
                            ' <span class="fas fa-clipboard-check"> </span> ',
                            $url
                        );
                    },

                    'update' => function ($url, $model) {
                        if ($model['type'] == Prixod::TYPE_RETURN) {
                            return Html::a(
                                ' <span class="fas fa-edit"> </span> ',
                                Yii::$app->getUrlManager()->createUrl(
                                array('return/update', 'id' => $model['id'])
                                ),
                            );

                        }
                        return Html::a(
                            ' <span class="fas fa-edit"> </span> ',
                            $url
                        );
                    },

                    'delete' => function ($url, $model) {

                        /** @var $model Prixod */
                        if ($model->prixodGoods) {
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

