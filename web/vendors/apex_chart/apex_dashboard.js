var options = {
    series: [74],
    chart: {height: 300, type: 'radialBar', offsetY: 0},
    plotOptions: {
        radialBar: {
            startAngle: -90,
            endAngle: 90,
            hollow: {margin: 0, size: "70%"},
            dataLabels: {
                showOn: "always",
                name: {show: true, fontSize: "13px", fontWeight: "700", offsetY: -5, color: ["#000000", "#E5ECFF"],},
                value: {color: ["#000000", "#E5ECFF"], fontSize: "30px", fontWeight: "700", offsetY: -40, show: true}
            },
            track: {background: ["#E5ECFF", "#E5ECFF"], strokeWidth: '100%'}
        }
    },
    colors: ["#9767FD", "#E5ECFF"],
    stroke: {lineCap: "round",},
    labels: ["Progress"]
};
var chart = new ApexCharts(document.querySelector("#chart-currently"), options);
chart.render();

var options = {
    series: [{name: 'Net Profit', data: [30, 25, 45, 30, 55, 55]}],
    chart: {
        type: 'area',
        height: 270,
        offsetY: 0,
        toolbar: {show: false},
        zoom: {enabled: false},
        sparkline: {enabled: true}
    },
    plotOptions: {},
    legend: {show: false},
    dataLabels: {enabled: false},
    fill: {type: 'solid', opacity: .2},
    stroke: {curve: 'smooth', show: true, width: 3, colors: ["#9767FD", "#E5ECFF"],},
    xaxis: {
        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        axisBorder: {show: false,},
        axisTicks: {show: false},
        labels: {show: false, style: {fontSize: '12px',}},
        crosshairs: {show: false, position: 'front', stroke: {color: ["#9767FD", "#E5ECFF"], width: 1, dashArray: 3}},
        tooltip: {enabled: true, formatter: undefined, offsetY: 0, style: {fontSize: '12px',}}
    },
    yaxis: {min: 0, max: 60, labels: {show: false, style: {fontSize: '12px',}}},
    states: {
        normal: {filter: {type: 'none', value: 0}},
        hover: {filter: {type: 'none', value: 0}},
        active: {allowMultipleDataPointsSelection: false, filter: {type: 'none', value: 0}}
    },
    tooltip: {
        style: {fontSize: '12px',}, y: {
            formatter: function (val) {
                return "$" + val + " thousands"
            }
        }
    },
    colors: ["#9767FD", "#E5ECFF"],
    markers: {colors: ["#9767FD", "#E5ECFF"], strokeColor: ["#9767FD", "#E5ECFF"], strokeWidth: 3}
};
var chart = new ApexCharts(document.querySelector("#chart4"), options);
chart.render();