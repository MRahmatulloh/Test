<?php

use app\modules\cash\models\PaymentReason;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\cash\models\search\PaymentReasonSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Причины оплаты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-reason-index">

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
        'layout' => '{summary}' . Html::activeDropDownList($searchModel, 'myPageSize', [20 => 20, 50 => 50, 100 => 100, 300 => 300, 500 => 500], ['id' => 'myPageSize']) . "{items}<br/>{pager}",
        'filterModel' => $searchModel,
        'filterSelector' => '#myPageSize',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'type_id',
                'value' => function ($model) {
                    return $model->type_id == 1 ? 'Приход' : 'Расход';
                },
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete}',
                'urlCreator' => function ($action, PaymentReason $model, $key, $index, $column) {
                    /** @var $model PaymentReason */
                    if ($action === 'delete' && ($model->expenses or $model->payments)) {
                        return Html::a('<span class="fas fa-trash"></span>',
                            '#',
                            [
                                'title' => Yii::t('yii', 'Delete'),
                                'onclick' => 'alert("Эта запись используется и её нельзя удалить!"); return false;'
                            ]);
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
