<?php

use app\assets\AppAsset;
use app\models\Currency;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\cash\models\search\CashSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\widgets\ActiveForm $form */
/** @var Array $stats */

$this->title = 'Касса';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
?>
<div class="cash-index">

    <div class="row">
        <div class="col-12">
        </div>
        <div class="col-6">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="col-6">
            <table class="table">
                <tbody>
                <tr>
                    <th>Валюта</th>
                    <th>Приход</th>
                    <th>Расход</th>
                    <th>Итог</th>
                </tr>
                <tr>
                    <td>СУМ</td>
                    <td><?= pul2($stats['prixod']['sum'] ?? 0, 2) ?></td>
                    <td><?= pul2($stats['rasxod']['sum'] ?? 0, 2) ?></td>
                    <td><?= pul2(($stats['prixod']['sum'] ?? 0) - ($stats['rasxod']['sum'] ?? 0), 2) ?></td>
                </tr>
                <tr>
                    <td>USD</td>
                    <td><?= pul2($stats['prixod']['usd'] ?? 0, 2) ?></td>
                    <td><?= pul2($stats['rasxod']['usd'] ?? 0, 2) ?></td>
                    <td><?= pul2(($stats['prixod']['usd'] ?? 0) - ($stats['rasxod']['usd'] ?? 0), 2) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="cash-form">

        <?php $form = ActiveForm::begin(['method' => 'get']); ?>

        <div class="row">
            <div class="col-md-2">
                <?= $form->field($searchModel, 'from')->widget(DatePicker::classname(), [
                    'type' => 3,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy',
                    ]
                ]); ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($searchModel, 'to')->widget(DatePicker::classname(), [
                    'type' => 3,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy',
                    ]
                ]); ?>
            </div>

            <div class="col-md-3">
                <h6> </h6>
                <?= Html::submitButton('Показать', ['class' => 'btn btn-success']) ?>
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
                'label' => 'Дата',
                'value' => function ($data) {
                    return dateView($data['date']);
                },
                'filter' => ''
            ],

            [
                'label' => 'Клиент',
                'attribute' => 'client_name',
                'value' => function ($data) {
                    return $data['client_name'];
                },
            ],

            [
                'attribute' => 'Приход',
                'value' => function ($data) {
                    if ($data['type'] == 'payment')
                        return pul2($data['summa'], 2);

                    return '';
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'Расход',
                'value' => function ($data) {
                    if ($data['type'] == 'expense')
                        return pul2($data['summa'], 2);

                    return '';
                },
                'contentOptions' => ['class' => 'text-right'],
                'filter' => ''
            ],

            [
                'attribute' => 'currency_id',
                'value' => function ($data) {
                    return $data['currency_name'];
                },
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
        ],
    ]); ?>


</div>