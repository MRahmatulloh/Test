<?php

use app\models\Movement;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\MovementSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Перемещение';
$this->params['breadcrumbs'][] = $this->title;
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

            'comment',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'template' => '{accept} {update} {delete}',
                'buttons' => [
                    'accept' => function ($url, $model) {
                        if ($model->status == Movement::STATUS_NEW) {
                            return Html::a('<span class="fas fa-check"></span>', Url::to(['movement/accept', 'id' => $model->id]), [
                                'title' => 'Подтвердить',
                                'class' => 'btn btn-sm btn-success',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите подтвердить этот элемент?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="fas fa-pencil-alt"></span>', Url::to(['movement/update', 'id' => $model->id]), [
                            'title' => 'Редактировать',
                            'class' => 'btn btn-sm btn-primary',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        /** @var $model \app\models\Movement */
                        if ($model->movementGoods) {
                            return Html::a('<span class="fas fa-trash"></span>',
                                $url,
                                [
                                    'title' => 'Удалить',
                                    'class' => 'btn btn-sm btn-danger',
                                    'onclick' => 'alert("Эта запись используется и её нельзя удалить!"); return false;'
                                ]);
                        }
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
            ],
        ],
    ]); ?>


</div>
