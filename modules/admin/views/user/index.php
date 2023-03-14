<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Пользователи');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="row">
        <div class="col-6">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="col-6">
            <p class="text-right">
                <?= Html::a("<i class='fas fa-plus white_text'></i> " . ' Создать', ['signup'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status == 0 ? 'Inactive' : 'Active';
                },
                'filter' => [
                    0 => 'Inactive',
                    10 => 'Active'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn(['view', 'activate', 'delete', 'deactive']),
                'buttons' => [
                    'delete' => function ($url, $model) {
                        if ($model->id == 1) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('rbac-admin', 'Delete'),
                            'aria-label' => Yii::t('rbac-admin', 'Delete'),
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to delete this user?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="fa fa-trash"></span>', $url, $options);
                    },
                    'activate' => function ($url, $model) {
                        if ($model->status == 10) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('rbac-admin', 'Activate'),
                            'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
                    },
                    'deactive' => function ($url, $model) {
                        if ($model->status == 0) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('rbac-admin', 'Deactive'),
                            'aria-label' => Yii::t('rbac-admin', 'Deactive'),
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to deactive this user?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, $options);
                    },
                ]
            ],
        ],
    ]);
    ?>
</div>
