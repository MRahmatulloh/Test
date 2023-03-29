<?php

use app\assets\AppAsset;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PrixodGoodsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\PrixodGoods $model */
/** @var yii\widgets\ActiveForm $form */

AppAsset::register($this);
?>
    <div class="prixod-goods-index p-3">

        <h2>НАКЛАДНАЯ №<?= $model->prixod->number ?> от <?= dateView($model->prixod->date) ?></h2>
        <table class="table table-active w-50 h4">
            <tr>
                <td>Продавец</td>
                <td>ООО «7 MARKET»</td>
            </tr>
            <tr>
                <td>Покупатель</td>
                <td><?= $model->prixod->client->name ?></td>
            </tr>
            <tr>
                <td>Склад</td>
                <td><?= $model->prixod->warehouse->name ?></td>
            </tr>
        </table>
        <br>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}',
            'filterModel' => null,
            'tableOptions' => ['class' => 'table table-bordered table-hover w-50 h4'],
            'showFooter' => true,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'goods_id',
                    'value' => function ($model) {
                        return $model->goods->code . '-' . $model->goods->name;
                    },
                    'filter' => ''
                ],

                [
                    'attribute' => 'amount',
                    'value' => function ($model) {
                        return pul2($model->amount, 2);
                    },
                    'contentOptions' => ['class' => 'text-right'],
                    'filter' => '',
                    'footer' => pul2(array_sum(array_column($dataProvider->models, 'amount')), 2),
                    'footerOptions' => ['class' => 'text-right'],
                ],
            ],
        ]); ?>

    </div>

<?php
$prixod_id = $model->prixod_id;
$script = <<< JS
    const prixod_id = $prixod_id;
    html2canvas(document.body).then(function(canvas) {
        send(canvas, prixod_id);
        // document.body.appendChild(canvas);
        // console.log(canvas.toDataURL("image/png"))
    });
    function send(canvas, prixod_id) {
        $.post('/prixod/nakladnoy?prixod_id=' + prixod_id, {data: canvas.toDataURL("image/png"), _csrf: yii.getCsrfToken()}, function (data) {
            history.back();
        });
    }
    
JS;

$this->registerJs($script, yii\web\View::POS_READY);

?>