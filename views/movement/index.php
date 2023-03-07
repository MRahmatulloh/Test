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
                'value' => function($model){
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
                'value' => function($model){
                    return $model->sender->name;
                }
            ],

            [
                'attribute' => 'recipient_id',
                'value' => function($model){
                    return $model->recipient->name;
                }
            ],

            [
                'attribute' => 'prixod_id',
                'value' => function($model){
                    return $model->prixod->name ?? '';
                }
            ],

            [
                'attribute' => 'rasxod_id',
                'value' => function($model){
                    return $model->rasxod->name ?? '';
                }
            ],

            'status',
            'comment',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Movement $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
