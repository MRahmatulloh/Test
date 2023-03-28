<?php

use app\assets\AppAsset;
use yii\bootstrap5\Modal;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var string $from */
/** @var string $to */
/** @var array $data */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
?>
<div class="dashboard-index">

    <section class="">
        <div class="main_content_iner overly_inner ">
            <div class="container-fluid p-0 ">
                <div class="row">
                    <div class="col-12">
                        <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                            <div class="page_title_left d-flex align-items-center">
                                <h3 class="f_s_25 f_w_700 dark_text mr_30"><?= Html::encode($this->title) ?></h3>
                                <ol class="breadcrumb page_bradcam mb-0">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                                    <li class="breadcrumb-item active">Analytic</li>
                                </ol>
                            </div>
                            <div class="">
                                <div class="page_date_button d-flex align-items-center">

                                    <form action="" method="get">
                                        <div class="row justify-content-around">
                                            <div class="col-md-5">
                                                <?= Html::label(Yii::t('app', 'Дата «С»'), 'from') ?>
                                                <?= Html::input('date', 'from', $from, [
                                                    'class' => 'form-control',
                                                ]) ?>
                                            </div>
                                            <div class="col-md-5">
                                                <?= Html::label(Yii::t('app', '«По»'), 'to') ?>
                                                <?= Html::input('date', 'to', $to, [
                                                    'class' => 'form-control',
                                                ]) ?>
                                            </div>
                                            <div class="col-md-2">
                                                <label>&nbsp;</label>
                                                <button class="btn btn-primary"
                                                        type="submit"><?= Yii::t('app', 'ОК') ?></button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="white_card card_height_100 mb_30 overflow_hidden">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">Sotuv</h3>
                                    </div>
                                    <div class="header_more_tool">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" id="dropdownMenuButton"
                                                  data-bs-toggle="dropdown">
                                            <i class="ti-more-alt"></i>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                 aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#"> <i class="ti-eye"></i> Action</a>
                                                <a class="dropdown-item" href="#"> <i class="ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="#"> <i class="fas fa-edit"></i> Edit</a>
                                                <a class="dropdown-item" href="#"> <i class="ti-printer"></i> Print</a>
                                                <a class="dropdown-item" href="#"> <i class="fa fa-download"></i>
                                                    Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body pb-0">
                                <div class="Sales_Details_plan">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="single_plan d-flex align-items-center justify-content-between">
                                                <div class="plan_left d-flex align-items-center">
                                                    <div class="thumb">
                                                        <img src="img/icon2/1.svg" alt="">
                                                    </div>
                                                    <div>
                                                        <h5>$<?= pul2($data['sales_total']['rasxod'], 2) ?></h5>
                                                        <span>Sotildi</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="single_plan d-flex align-items-center justify-content-between">
                                                <div class="plan_left d-flex align-items-center">
                                                    <div class="thumb">
                                                        <img src="img/icon2/3.svg" alt="">
                                                    </div>
                                                    <div>
                                                        <h5>$<?= pul2($data['sales_total']['prixod'], 2) ?></h5>
                                                        <span>Olindi</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="single_plan d-flex align-items-center justify-content-between">
                                                <div class="plan_left d-flex align-items-center">
                                                    <div class="thumb">
                                                        <img src="img/icon2/2.svg" alt="">
                                                    </div>
                                                    <div>
                                                        <h5>$<?= pul2($data['sales_total']['profit'], 2) ?></h5>
                                                        <span>Foyda</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <div id="management_bar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="white_card card_height_100 mb_30 overflow_hidden">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">Kassa</h3>
                                    </div>
                                    <div class="header_more_tool">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" id="dropdownMenuButton"
                                                  data-bs-toggle="dropdown">
                                            <i class="ti-more-alt"></i>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                 aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#"> <i class="ti-eye"></i> Action</a>
                                                <a class="dropdown-item" href="#"> <i class="ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="#"> <i class="fas fa-edit"></i> Edit</a>
                                                <a class="dropdown-item" href="#"> <i class="ti-printer"></i> Print</a>
                                                <a class="dropdown-item" href="#"> <i class="fa fa-download"></i>
                                                    Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body pb-0">
                                <div class="Sales_Details_plan">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="single_plan d-flex align-items-center justify-content-between">
                                                <div class="plan_left d-flex align-items-center">
                                                    <div class="thumb">
                                                        <img src="img/icon2/3.svg" alt="">
                                                    </div>
                                                    <div>
                                                        <h5>+$<?= pul2($data['kassa_total']['kassa_kirim'], 2) ?></h5>
                                                        <span>Kirim</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="single_plan d-flex align-items-center justify-content-between">
                                                <div class="plan_left d-flex align-items-center">
                                                    <div class="thumb">
                                                        <img src="img/icon2/1.svg" alt="">
                                                    </div>
                                                    <div>
                                                        <h5>-$<?= pul2($data['kassa_total']['kassa_chiqim'], 2) ?></h5>
                                                        <span>Chiqim</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="single_plan d-flex align-items-center justify-content-between">
                                                <div class="plan_left d-flex align-items-center">
                                                    <div class="thumb">
                                                        <img src="img/icon2/2.svg" alt="">
                                                    </div>
                                                    <div>
                                                        <h5>
                                                            =$<?= pul2($data['kassa_total']['kassa_kirim'] - $data['kassa_total']['kassa_chiqim'], 2) ?></h5>
                                                        <span>Farq</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <div id="management_bar1"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-xl-3 ">
                        <div class="white_card card_height_100 mb_30 user_crm_wrapper">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="single_crm">
                                        <div class="crm_head d-flex align-items-center justify-content-between">
                                            <div class="thumb">
                                                <img src="img/crm/businessman.svg" alt="">
                                            </div>
                                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                                        </div>
                                        <div class="crm_body">
                                            <h4><?= $data['clients_total'] ?></h4>
                                            <p>Mijozlar</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single_crm ">
                                        <div class="crm_head crm_bg_1 d-flex align-items-center justify-content-between">
                                            <div class="thumb">
                                                <img src="img/crm/customer.svg" alt="">
                                            </div>
                                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                                        </div>
                                        <div class="crm_body">
                                            <h4><?= $data['goods_total'] ?></h4>
                                            <p>Tovarlar turi</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single_crm">
                                        <div class="crm_head crm_bg_2 d-flex align-items-center justify-content-between">
                                            <div class="thumb">
                                                <img src="img/crm/infographic.svg" alt="">
                                            </div>
                                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                                        </div>
                                        <div class="crm_body">
                                            <h4><?= $data['users_total'] ?></h4>
                                            <p>Foydalanuvchilar</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single_crm">
                                        <div class="crm_head crm_bg_3 d-flex align-items-center justify-content-between">
                                            <div class="thumb">
                                                <img src="img/crm/sqr.svg" alt="">
                                            </div>
                                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                                        </div>
                                        <div class="crm_body">
                                            <h4><?= $data['warehouses_total'] ?></h4>
                                            <p>Skladlar</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="crm_reports_bnner">
                                <div class="row justify-content-end ">
                                    <div class="col-lg-6">
                                        <h4>Create CRM Reports</h4>
                                        <p>Outlines keep you and honest
                                            indulging honest.</p>
                                        <a href="#">Read More <i class="fas fa-arrow-right"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="row align-items-center">
                                    <div class="col-lg-12">
                                        <div class="main-title">
                                            <h3 class="m-0">TOP 5 Mijozlar</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body ">
                                <?php if ($data['top_clients']): ?>
                                    <?php foreach ($data['top_clients'] as $client): ?>
                                        <div class="single_user_pil d-flex align-items-center justify-content-between">
                                            <div class="user_pils_thumb d-flex align-items-center">
                                                <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                                      src="img/customers/1.png" alt="">
                                                </div>
                                                <span class="f_s_14 f_w_400 text_color_11"><?= $client['name'] ?></span>
                                            </div>
                                            <div class="user_info">
                                                <?= pul2($client['summa'], 2) ?> $
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="white_card card_height_100 mb_20 ">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">TOP 7 Tovarlar</h3>
                                    </div>
                                    <div class="header_more_tool">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" id="dropdownMenuButton"
                                                  data-bs-toggle="dropdown">
                                            <i class="ti-more-alt"></i>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                 aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#"> <i class="ti-eye"></i> Action</a>
                                                <a class="dropdown-item" href="#"> <i class="ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="#"> <i class="fas fa-edit"></i> Edit</a>
                                                <a class="dropdown-item" href="#"> <i class="ti-printer"></i> Print</a>
                                                <a class="dropdown-item" href="#"> <i class="fa fa-download"></i>
                                                    Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body QA_section">
                                <div class="QA_table ">

                                    <table class="table lms_table_active2 p-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">Tovar</th>
                                            <th scope="col">Soni</th>
                                            <th scope="col">Summa</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if ($data['top_goods']): ?>

                                            <?php foreach ($data['top_goods'] as $good): ?>
                                                <tr>
                                                    <td>
                                                        <div class="customer d-flex align-items-center">
                                                            <div class="thumb_34 mr_15 mt-0"><img
                                                                        class="img-fluid radius_50"
                                                                        src="img/customers/pro_1.png"
                                                                        alt=""></div>
                                                            <span class="f_s_12 f_w_600 color_text_5"><?= $good['name'] ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="f_s_12 f_w_400 color_text_6"><?= $good['amount'] ?></td>
                                                    <td class="f_s_12 f_w_400 color_text_7"><?= pul2($good['summa'], 2) ?>
                                                        $
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="white_card card_height_100 mb_30 overflow_hidden">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">Sklad</h3>
                                    </div>
                                    <div class="header_more_tool">
                                        <div class="dropdown">
<span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown">
<i class="ti-more-alt"></i>
</span>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                 aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#"> <i class="ti-eye"></i> Action</a>
                                                <a class="dropdown-item" href="#"> <i class="ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="#"> <i class="fas fa-edit"></i> Edit</a>
                                                <a class="dropdown-item" href="#"> <i class="ti-printer"></i> Print</a>
                                                <a class="dropdown-item" href="#"> <i class="fa fa-download"></i>
                                                    Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body pb-0">
                                <div class="Sales_Details_plan">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="single_plan d-flex align-items-center justify-content-between">
                                                <div class="plan_left d-flex align-items-center">
                                                    <div class="thumb">
                                                        <img src="img/icon2/3.svg" alt="">
                                                    </div>
                                                    <div>
                                                        <h5>$<?= pul2( $data['warehouse']['summa'],2)?></h5>
                                                        <span>Skladdagi joriy aktiv</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single_plan d-flex align-items-center justify-content-between">
                                                <div class="plan_left d-flex align-items-center">
                                                    <div class="thumb">
                                                        <img src="img/icon2/1.svg" alt="">
                                                    </div>
                                                    <div>
                                                        <h5><?= pul2( $data['warehouse']['amount'],2)?> шт.</h5>
                                                        <span>Skladdagi joriy miqor</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

<?php
$rasxod = json_encode(array_column($data['sales'], 'rasxod_summa'));
//$prixod = json_encode(array_column($data['sales'], 'prixod_summa'));
$profit = json_encode(array_column($data['sales'], 'profit_summa'));

$labels = json_encode(array_column($data['sales'], 'date'));

$js = <<<JS
const rasxod = $rasxod;
const profit = $profit;
const labels = $labels;

SotuvOptions = {
    chart: {height: 339, type: "line", stacked: !1, toolbar: {show: !1}},
    stroke: {width: [2, 3], curve: "smooth"},
    colors: ["#ff7ea5", "#20c997"],
    series: [
        {
            name: "Sotuv",
            type: "line",
            data: rasxod
        }, 
        {
            name: "Foyda", 
            type: "line", 
            data: profit
        }
        ],
    labels: labels,
    markers: {size: 0},
    xaxis: {
      labels: {
        show: true,
        rotate: -45,
        rotateAlways: true,
        minHeight: 100,
        maxHeight: 180,
        // style: {
        //   colors: "red"
        // }
      },
      categories: labels
    },
    yaxis: {title: {text: "Mablag'"}},
    tooltip: {
        shared: !0, intersect: !1, y: {
            formatter: function (e) {
                return void 0 !== e ? e.toFixed(0) + " USD" : e;
            },
        },
    },
    grid: {borderColor: "#f1f1f1"},
};
(chart = new ApexCharts(document.querySelector("#management_bar"), SotuvOptions)).render();

JS;

$rasxod = json_encode(array_column($data['kassa'], 'chiqim_summa'));
$prixod = json_encode(array_column($data['kassa'], 'kirim_summa'));

$labels = json_encode(array_column($data['kassa'], 'date'));

$js .= <<<JS

const rasxod_kassa = $rasxod;
const prixod_kassa = $prixod;
const labels_kassa = $labels;

KassaOptions = {
    chart: {height: 339, type: "line", stacked: !1, toolbar: {show: !1}},
    stroke: {width: [2, 4], curve: "smooth"},
    plotOptions: {bar: {columnWidth: "30%"}},
    colors: ["#9767FD", "#ff7ea5"],
    series: [
        {
            name: "Kirim", 
            type: "line", 
            data: prixod_kassa
        },
        {
            name: "Chiqim",
            type: "line",
            data: rasxod_kassa
        }
        ],
    // fill: {
    //     opacity: [0.85, 1],
    //     gradient: {
    //         inverseColors: !1,
    //         shade: "light",
    //         type: "vertical",
    //         opacityFrom: 0.85,
    //         opacityTo: 0.55,
    //         stops: [0, 100, 100, 100]
    //     }
    // },
    labels: labels_kassa,
    markers: {size: 0},
    xaxis: {
      labels: {
        show: true,
        rotate: -45,
        rotateAlways: true,
        minHeight: 100,
        maxHeight: 180,
        // style: {
        //   colors: "red"
        // }
      },
      categories: labels_kassa
    },
    yaxis: {title: {text: "Mablag'"}},
    tooltip: {
        shared: !0, intersect: !1, y: {
            formatter: function (e) {
                return void 0 !== e ? e.toFixed(0) + " USD" : e;
            },
        },
    },
    grid: {borderColor: "#f1f1f1"},
};
(chart = new ApexCharts(document.querySelector("#management_bar1"), KassaOptions)).render();

JS;

$this->registerJs($js);
?>

