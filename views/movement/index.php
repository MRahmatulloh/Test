<?php

use app\assets\AppAsset;
use app\models\Movement;
use app\models\Warehouse;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\MovementSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Перемещение';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
?>
<div class="movement-index">

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

    <div style="width: 100%; overflow: scroll;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{summary}' . Html::activeDropDownList($searchModel, 'myPageSize', [20 => 20, 50 => 50, 100 => 100, 300 => 300, 500 => 500], ['id' => 'myPageSize']) . "{items}<br/>{pager}",
            'filterModel' => $searchModel,
            'filterSelector' => '#myPageSize',
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

                        return Html::a(
                            $number,
                            \Yii::$app->getUrlManager()->createUrl(
                                array('movement/goods-list', 'id' => $model['id'])
                            ),
                        );
                    },
                ],

                [
                    'attribute' => 'sender_id',
                    'value' => function ($model) {
                        return $model->sender->name;
                    }
                ],

                [
                    'attribute' => 'recipient_id',
                    'value' => function ($model) {
                        return $model->recipient->name;
                    }
                ],

                [
                    'attribute' => 'prixod_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var Movement $model */
                        $number = $model->prixod->number ?? '';
                        if ($number)
                            return Html::a(
                                $number,
                                \Yii::$app->getUrlManager()->createUrl(
                                    array('prixod/goods-list', 'prixod_id' => $model->prixod->id)
                                ),
                            );
                        return '';
                    },
                ],

                [
                    'attribute' => 'rasxod_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var Movement $model */
                        $number = $model->rasxod->number ?? '';
                        if ($number)
                            return Html::a(
                                $number,
                                \Yii::$app->getUrlManager()->createUrl(
                                    array('rasxod/goods-list', 'rasxod_id' => $model->rasxod->id)
                                ),
                            );
                        return '';
                    },
                ],

                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        return $model::STATUS_ALL[$model->status] ?? '';
                    }
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

                'comment',

                [
                    'class' => ActionColumn::className(),
                    'template' => '{accept} {update} {delete}',
                    'buttons' => [
                        'accept' => function ($url, $model) {
                            /** @var $model \app\models\Movement */
                            if (empty($model->movementGoods)) {
                                return Html::a('<span class="fas fa-check"></span>',
                                    $url,
                                    [
                                        'title' => 'Подтвердить',
                                        'class' => 'btn btn-sm btn-success',
                                        'onclick' => 'alert("У этого перемещения нет товаров!"); return false;'
                                    ]);
                            }

                            if ($model->status == Movement::STATUS_NEW) {
                                return Html::a('<span class="fas fa-check"></span>', Url::to(['movement/accept', 'id' => $model->id]), [
                                    'title' => 'Подтвердить',
                                    'class' => 'btn btn-sm btn-success',
                                    'data' => [
                                        'confirm' => 'Вы уверены, что хотите подтвердить?',
                                        'method' => 'post',
                                    ],
                                ]);
                            }
                        },
                        'update' => function ($url, $model) {
                            /** @var $model \app\models\Movement */
                            if ($model->status == Movement::STATUS_ACCEPTED) {
                                return Html::a('<span class="fas fa-pencil-alt"></span>',
                                    $url,
                                    [
                                        'title' => 'Редактировать',
                                        'class' => 'btn btn-sm btn-primary',
                                        'onclick' => 'alert("Перемещение потверждено и её нельзя изменить!"); return false;'
                                    ]);
                            }

                            return Html::a('<span class="fas fa-pencil-alt"></span>', Url::to(['movement/update', 'id' => $model->id]), [
                                'title' => 'Редактировать',
                                'class' => 'btn btn-sm btn-primary',
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            /** @var $model \app\models\Movement */
                            return Html::a('<span class="fas fa-trash-alt"></span>', Url::to(['movement/delete', 'id' => $model->id]), [
                                'title' => 'Удалить',
                                'class' => 'btn btn-sm btn-danger',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                    'method' => 'post',
                                ],
                            ]);
                        },
                    ],
                    'contentOptions' => ['style' => 'min-width:130px;'],
                ],
            ],
        ]); ?>
    </div>

</div>
