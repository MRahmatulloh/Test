<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "css/bootstrap1.min.css",
        "vendors/themefy_icon/themify-icons.css",
        "vendors/niceselect/css/nice-select.css",
        "vendors/owl_carousel/css/owl.carousel.css",
        "vendors/gijgo/gijgo.min.css",
        "vendors/font_awesome/css/all.min.css",
        "vendors/tagsinput/tagsinput.css",
//        "vendors/datepicker/date-picker.css",
//        "vendors/vectormap-home/vectormap-2.0.2.css",
        "vendors/scroll/scrollable.css",
        "vendors/datatable/css/jquery.dataTables.min.css",
        "vendors/datatable/css/responsive.dataTables.min.css",
        "vendors/datatable/css/buttons.dataTables.min.css",
        "vendors/text_editor/summernote-bs4.css",
        "vendors/morris/morris.css",
        "vendors/material_icon/material-icons.css",
        "css/metisMenu.css",
        "css/style1.css",
        "css/colors/default.css"
    ];
    public $js = [
//        "js/jquery1-3.4.1.min.js",
        "js/popper1.min.js",
        "js/bootstrap1.min.js",
        "js/metisMenu.js",
        "vendors/count_up/jquery.waypoints.min.js",
        "vendors/chartlist/Chart.min.js",
        "vendors/count_up/jquery.counterup.min.js",
        "vendors/niceselect/js/jquery.nice-select.min.js",
        "vendors/owl_carousel/js/owl.carousel.min.js",
        "vendors/datatable/js/jquery.dataTables.min.js",
        "vendors/datatable/js/dataTables.responsive.min.js",
        "vendors/datatable/js/dataTables.buttons.min.js",
        "vendors/datatable/js/buttons.flash.min.js",
        "vendors/datatable/js/jszip.min.js",
        "vendors/datatable/js/pdfmake.min.js",
        "vendors/datatable/js/vfs_fonts.js",
        "vendors/datatable/js/buttons.html5.min.js",
        "vendors/datatable/js/buttons.print.min.js",
        "vendors/datepicker/datepicker.js",
        "vendors/datepicker/datepicker.en.js",
        "vendors/datepicker/datepicker.custom.js",
        "js/chart.min.js",
        "vendors/chartjs/roundedBar.min.js",
        "vendors/progressbar/jquery.barfiller.js",
        "vendors/tagsinput/tagsinput.js",
        "vendors/text_editor/summernote-bs4.js",
        "vendors/am_chart/amcharts.js",
        "vendors/scroll/perfect-scrollbar.min.js",
        "vendors/scroll/scrollable-custom.js",
//        "vendors/vectormap-home/vectormap-2.0.2.min.js",
//        "vendors/vectormap-home/vectormap-world-mill-en.js",
        "vendors/apex_chart/apex-chart2.js",
        "vendors/apex_chart/apex_dashboard.js",
        "vendors/chart_am/core.js",
        "vendors/chart_am/charts.js",
        "vendors/chart_am/animated.js",
        "vendors/chart_am/kelly.js",
        "vendors/chart_am/chart-custom.js",
        "js/dashboard_init.js",
        "js/custom.js",
        'js/html2canvas.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
