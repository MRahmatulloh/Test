<?php

use app\models\PrixodGoods;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PrixodGoodsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Prixod Goods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prixod-goods-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Create Prixod Goods', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{summary}' . Html::activeDropDownList($searchModel, 'myPageSize', [20 => 20, 50 => 50, 100 => 100, 300 => 300, 500 => 500], ['id' => 'myPageSize']) . "{items}<br/>{pager}",
        'filterModel' => $searchModel,
        'filterSelector' => '#myPageSize',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'prixod_id',
            'goods_id',
            'amount',
            'cost',
            //'cost_usd',
            //'currency_id',
            //'user_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PrixodGoods $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
