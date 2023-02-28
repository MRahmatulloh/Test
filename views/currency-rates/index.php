<?php

use app\assets\AppAsset;
use app\models\Kurs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\CurrencyRatesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $moneyList */

$this->title = 'Курс валюты';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
?>

<div class="kurs-index">

    <div class="row">
        <div class="col-6">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="col-6">
            <p class="text-right">
                <?= Html::a("<i class='fas fa-arrow-circle-down white_text'></i> " . 'Обновление', ['update-kurs'], ['class' => 'btn btn-primary']) ?>
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
                'label' => 'Валюта',
                'attribute' => 'code',
                'value' => 'currency.name',
            ],

            [
                'attribute' => 'rate',
                'value' => function($data){
                    return pul2($data->rate,2);
                },
                'contentOptions' => ['class' => 'text-right'],
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete}',
                'buttons' => [

                    'update' => function ($url, $model) {
                        return \yii\helpers\Html::a(
                            ' <span class="fas fa-edit"> </span> ',
                            $url
                        );
                    },

                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="fas fa-trash"></span>',
                            $url,
                            [
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Осторожно! Эта запись может быть использован. Вы уверены, что хотите удалить этот элемент?'),
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