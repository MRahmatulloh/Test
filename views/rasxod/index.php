<?php

use app\assets\AppAsset;
use kartik\select2\Select2;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\RasxodSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Список расходов';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
?>
<div class="rasxod-index">

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
                'value' => function ($data) {

                    return \yii\helpers\Html::a(
                        $data['number'],
                        \Yii::$app->getUrlManager()->createUrl(
                            array('rasxod/goods-list', 'rasxod_id' => $data['id'])
                        ),
                        ['class' => 'clickLock']
                    );
                },
            ],

            [
                'attribute' => 'client_id',
                'value' => 'client.name',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'client_id',
                    'data' => \app\models\Client::selectList(),
                    'initValueText' => $searchModel->client_id,
                    'options' => ['placeholder' => 'Выберите клиент ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],

            'comment',

            [
                'attribute' => 'warehouse_id',
                'value' => 'warehouse.name',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'warehouse_id',
                    'data' => \app\models\Warehouse::selectList(),
                    'initValueText' => $searchModel->warehouse_id,
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
                        return \yii\helpers\Html::a(
                            ' <span class="fas fa-edit"> </span> ',
                            $url
                        );
                    },

                    'delete' => function ($url, $model) {

                        /** @var $model \app\models\Rasxod */
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

<?php

// quyidagi scriptni alohida fayl deb qarash mumkin.
// ixtiyoriy '' va "" ishlatish mumkin.
// php o'zgaruvchilarni ham ishlatish mumkin.
$script = <<< JS
    $(document).ready(function() {
        window.PJAX_ENABLED = false;
        
        // comboboxda qidirish
        // $('.select2').select2();
        // $('.select2-clear').select2({
        //     allowClear: true
        // });
        //
        // $( ".datetimepicker-asdate" ).datetimepicker({
        //     format: 'DD.MM.YYYY'
        // });
    });
JS;
// Satr oxiri belgisi hech qanday probel va tabulyatsiyasiz qo'yilishi shart

$this->registerJs($script, yii\web\View::POS_READY);

?>
