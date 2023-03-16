<?php

use app\assets\AppAsset;
use app\models\Category;
use app\models\Goods;
use kartik\select2\Select2;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\GoodsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Goods $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
?>
<div class="goods-index">

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

            [
                'label' => 'Фото',
                'format' => 'raw',
                'value' => function (Goods $model) {
                    return Html::img('@web' . '/img/goods/' . $model->img, ['class' => 'img-fluid', 'width' => '80px']);
                }
            ],

            'code',
            'name',

            [
                'label' => 'C артикулом',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->code .'-'.$model->name, '#', [
                        'title' => 'Просмотр товара',
                        'data-url' => '/img/goods/' . $model->img,
                        'data-pjax' => '0',
                        'class' => 'modalButton'
                    ]);
                },
            ],

            [
                'attribute' => 'category_id',
                'value' => 'category.name',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'category_id',
                    'data' => Category::selectList(),
                    'initValueText' => $searchModel->category_id,
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
                        return Html::a(
                            ' <span class="fas fa-edit"> </span> ',
                            $url
                        );
                    },

                    'delete' => function ($url, Goods $model) {

                        if ($model->prixodGoods or $model->rasxodGoods) {
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
    ]);
    ?>

</div>

<?php
    Modal::begin([
        'title' => 'Фото товара',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent' style='width: min-content!important;'><img src='' alt='Нет фото товара' id='image' width='500px'></div>";
    Modal::end();
?>

<?php

$js = <<<JS

    $(document).on('click', '.modalButton', function() {
        $('#image').attr('src', $(this).data('url'));
        
        $('#modal').modal('show');
    });

JS;

$this->registerJs($js);
?>