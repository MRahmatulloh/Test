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
                                            <div class="single_plan d-flex align-items-center just['total]ify-content-between">
                                                <div class="plan_left d-flex align-items-center">
                                                    <div class="thumb">
                                                        <img src="img/icon2/1.svg" alt="">
                                                    </div>
                                                    <div>
                                                        <h5>$<?= pul2($data['total']['rasxod'], 2) ?></h5>
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
                                                        <h5>$<?= pul2($data['total']['prixod'], 2) ?></h5>
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
                                                        <h5>$<?= pul2($data['total']['profit'], 2) ?></h5>
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
                                                        <h5>+$<?= pul2($data['kassa_total']['kassa_kirim'],2) ?></h5>
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
                                                        <h5>-$<?= pul2($data['kassa_total']['kassa_chiqim'],2) ?></h5>
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
                                                        <h5>=$<?= pul2($data['kassa_total']['kassa_kirim'] - $data['kassa_total']['kassa_chiqim'], 2) ?></h5>
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
                    <div class="col-xl-4 ">
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
                                            <h4>2455</h4>
                                            <p>Tovarlar</p>
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
                                            <h4>2455</h4>
                                            <p>Mijozlar</p>
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
                                            <h4>2455</h4>
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
                                            <h4>2455</h4>
                                            <p>User Registrations</p>
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
                                    <div class="col-lg-4">
                                        <div class="main-title">
                                            <h3 class="m-0">TOP 10 Mijozlar</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row justify-content-end">
                                            <div class="col-lg-8 d-flex justify-content-end">
                                                <div class="serach_field-area theme_bg d-flex align-items-center">
                                                    <div class="search_inner">
                                                        <form action="#">
                                                            <div class="search_field">
                                                                <input type="text" placeholder="Search">
                                                            </div>
                                                            <button type="submit"><img src="img/icon/icon_search.svg"
                                                                                       alt=""></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-lg-4 mt_20">
                                        <select class="nice_Select2 wide">
                                            <option value="1">Show by All</option>
                                            <option value="1">Show by A</option>
                                            <option value="1">Show by B</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body ">
                                <div class="single_user_pil d-flex align-items-center justify-content-between">
                                    <div class="user_pils_thumb d-flex align-items-center">
                                        <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                              src="img/customers/1.png" alt=""></div>
                                        <span class="f_s_14 f_w_400 text_color_11">Jhon Smith</span>
                                    </div>
                                    <div class="user_info">
                                        Customer
                                    </div>
                                    <div class="action_btns d-flex">
                                        <a href="#" class="action_btn mr_10"> <i class="far fa-edit"></i> </a>
                                        <a href="#" class="action_btn"> <i class="fas fa-trash"></i> </a>
                                    </div>
                                </div>
                                <div class="single_user_pil admin_bg d-flex align-items-center justify-content-between">
                                    <div class="user_pils_thumb d-flex align-items-center">
                                        <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                              src="img/customers/1.png" alt=""></div>
                                        <span class="f_s_14 f_w_400 text_color_11">Jhon Smith</span>
                                    </div>
                                    <div class="user_info">
                                        Admin
                                    </div>
                                    <div class="action_btns d-flex">
                                        <a href="#" class="action_btn mr_10"> <i class="far fa-edit"></i> </a>
                                        <a href="#" class="action_btn"> <i class="fas fa-trash"></i> </a>
                                    </div>
                                </div>
                                <div class="single_user_pil d-flex align-items-center justify-content-between">
                                    <div class="user_pils_thumb d-flex align-items-center">
                                        <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                              src="img/customers/1.png" alt=""></div>
                                        <span class="f_s_14 f_w_400 text_color_11">Jhon Smith</span>
                                    </div>
                                    <div class="user_info">
                                        Customer
                                    </div>
                                    <div class="action_btns d-flex">
                                        <a href="#" class="action_btn mr_10"> <i class="far fa-edit"></i> </a>
                                        <a href="#" class="action_btn"> <i class="fas fa-trash"></i> </a>
                                    </div>
                                </div>
                                <div class="single_user_pil d-flex align-items-center justify-content-between">
                                    <div class="user_pils_thumb d-flex align-items-center">
                                        <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                              src="img/customers/1.png" alt=""></div>
                                        <span class="f_s_14 f_w_400 text_color_11">Jhon Smith</span>
                                    </div>
                                    <div class="user_info">
                                        Customer
                                    </div>
                                    <div class="action_btns d-flex">
                                        <a href="#" class="action_btn mr_10"> <i class="far fa-edit"></i> </a>
                                        <a href="#" class="action_btn"> <i class="fas fa-trash"></i> </a>
                                    </div>
                                </div>
                                <div class="single_user_pil d-flex align-items-center justify-content-between mb-0">
                                    <div class="user_pils_thumb d-flex align-items-center">
                                        <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                              src="img/customers/1.png" alt=""></div>
                                        <span class="f_s_14 f_w_400 text_color_11">Jhon Smith</span>
                                    </div>
                                    <div class="user_info">
                                        Customer
                                    </div>
                                    <div class="action_btns d-flex">
                                        <a href="#" class="action_btn mr_10"> <i class="far fa-edit"></i> </a>
                                        <a href="#" class="action_btn"> <i class="fas fa-trash"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">O'tkan hafta sotuvi</h3>
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
                            <div class="white_card_body">
                                <div id="chart-currently"></div>
                                <div class="monthly_plan_wraper">
                                    <div class="single_plan d-flex align-items-center justify-content-between">
                                        <div class="plan_left d-flex align-items-center">
                                            <div class="thumb">
                                                <img src="img/icon2/7.svg" alt="">
                                            </div>
                                            <div>
                                                <h5>Most Sales</h5>
                                                <span>Authors with the best sales</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single_plan d-flex align-items-center justify-content-between">
                                        <div class="plan_left d-flex align-items-center">
                                            <div class="thumb">
                                                <img src="img/icon2/6.svg" alt="">
                                            </div>
                                            <div>
                                                <h5>Total sales lead</h5>
                                                <span>40% increased on week-to-week reports</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single_plan d-flex align-items-center justify-content-between">
                                        <div class="plan_left d-flex align-items-center">
                                            <div class="thumb">
                                                <img src="img/icon2/5.svg" alt="">
                                            </div>
                                            <div>
                                                <h5>Average Bestseller</h5>
                                                <span>Pitstop Email Marketing</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="white_card card_height_100 mb_30 overflow_hidden">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">Sales Details</h3>
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
                                                        <h5>$2,034</h5>
                                                        <span>Author Sales</span>
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
                                                        <h5>$706</h5>
                                                        <span>Commision</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single_plan d-flex align-items-center justify-content-between">
                                                <div class="plan_left d-flex align-items-center">
                                                    <div class="thumb">
                                                        <img src="img/icon2/4.svg" alt="">
                                                    </div>
                                                    <div>
                                                        <h5>$49</h5>
                                                        <span>Average Bid</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single_plan d-flex align-items-center justify-content-between">
                                                <div class="plan_left d-flex align-items-center">
                                                    <div class="thumb">
                                                        <img src="img/icon2/2.svg" alt="">
                                                    </div>
                                                    <div>
                                                        <h5>$5.8M</h5>
                                                        <span>All Time Sales</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart_wrap overflow_hidden">
                                <div id="chart4"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="white_card card_height_100 mb_20 ">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">TOP 10 Tovarlar</h3>
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
                                            <th scope="col">Product 1</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Discount</th>
                                            <th scope="col">Sold</th>
                                            <th scope="col">Source</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                                          src="img/customers/pro_1.png"
                                                                                          alt=""></div>
                                                    <span class="f_s_12 f_w_600 color_text_5">Product 1</span>
                                                </div>
                                            </td>
                                            <td class="f_s_12 f_w_400 color_text_6">$564</td>
                                            <td class="f_s_12 f_w_400 color_text_7">#DE2548</td>
                                            <td class="f_s_12 f_w_400 color_text_6">60</td>
                                            <td class="f_s_12 f_w_400 text-end"><a href="#"
                                                                                   class="text_color_1">Google</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                                          src="img/customers/pro_2.png"
                                                                                          alt=""></div>
                                                    <span class="f_s_12 f_w_600 color_text_5">Product 2</span>
                                                </div>
                                            </td>
                                            <td class="f_s_12 f_w_400 color_text_6">$564</td>
                                            <td class="f_s_12 f_w_400 color_text_7">#DE2548</td>
                                            <td class="f_s_12 f_w_400 color_text_6">60</td>
                                            <td class="f_s_12 f_w_400 text-end"><a href="#"
                                                                                   class="text_color_2">Direct</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                                          src="img/customers/pro_3.png"
                                                                                          alt=""></div>
                                                    <span class="f_s_12 f_w_600 color_text_5">Product 3</span>
                                                </div>
                                            </td>
                                            <td class="f_s_12 f_w_400 color_text_6">$564</td>
                                            <td class="f_s_12 f_w_400 color_text_7">#DE2548</td>
                                            <td class="f_s_12 f_w_400 color_text_6">60</td>
                                            <td class="f_s_12 f_w_400 text-end"><a href="#"
                                                                                   class="text_color_1">Google</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                                          src="img/customers/pro_4.png"
                                                                                          alt=""></div>
                                                    <span class="f_s_12 f_w_600 color_text_5">Product 4</span>
                                                </div>
                                            </td>
                                            <td class="f_s_12 f_w_400 color_text_6">$564</td>
                                            <td class="f_s_12 f_w_400 color_text_7">#DE2548</td>
                                            <td class="f_s_12 f_w_400 color_text_6">60</td>
                                            <td class="f_s_12 f_w_400 text-end"><a href="#" class="text_color_1">Refferal</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                                          src="img/customers/pro_5.png"
                                                                                          alt=""></div>
                                                    <span class="f_s_12 f_w_600 color_text_5">Product 5</span>
                                                </div>
                                            </td>
                                            <td class="f_s_12 f_w_400 color_text_6">$564</td>
                                            <td class="f_s_12 f_w_400 color_text_7">#DE2548</td>
                                            <td class="f_s_12 f_w_400 color_text_6">60</td>
                                            <td class="f_s_12 f_w_400 text-end"><a href="#" class="text_color_1">20</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                                          src="img/customers/pro_6.png"
                                                                                          alt=""></div>
                                                    <span class="f_s_12 f_w_600 color_text_5">Product 6</span>
                                                </div>
                                            </td>
                                            <td class="f_s_12 f_w_400 color_text_6">$564</td>
                                            <td class="f_s_12 f_w_400 color_text_7">#DE2548</td>
                                            <td class="f_s_12 f_w_400 color_text_6">60</td>
                                            <td class="f_s_12 f_w_400 text-end"><a href="#"
                                                                                   class="text_color_5">Direct</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50"
                                                                                          src="img/customers/pro_6.png"
                                                                                          alt=""></div>
                                                    <span class="f_s_12 f_w_600 color_text_5">Product 6</span>
                                                </div>
                                            </td>
                                            <td class="f_s_12 f_w_400 color_text_6">$564</td>
                                            <td class="f_s_12 f_w_400 color_text_7">#DE2548</td>
                                            <td class="f_s_12 f_w_400 color_text_6">60</td>
                                            <td class="f_s_12 f_w_400 text-end"><a href="#"
                                                                                   class="text_color_5">Direct</a></td>
                                        </tr>
                                        </tbody>
                                    </table>
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
$rasxod = json_encode(array_column($data['rasxod'], 'summa'));
$prixod = json_encode(array_column($data['prixod'], 'summa'));
$profit = json_encode(array_column($data['profit'], 'summa'));

$labels = json_encode(array_column($data['rasxod'], 'date'));

$js = <<<JS
const rasxod = $rasxod;
const prixod = $prixod;
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
    xaxis: {type: "date"},
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
    xaxis: {type: "date"},
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

