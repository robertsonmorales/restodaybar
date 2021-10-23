var animations = {
    enabled: true,
    easing: 'easeinout',
    speed: 800,
    animateGradually: {
        enabled: true,
        delay: 150
    },
    dynamicAnimation: {
       enabled: true,
       speed: 350
    }
};

var chartOoptions = {
    type: 'area',
    stacked: false,
    markers: {
        size: 4,
    },
    animations: animations,
    toolbar: {
        show: false,
    },
};

var gridOptions = {
    show: true,
    borderColor: '#ddd',
    strokeDashArray: 1,
    position: 'back',
    xaxis: {
        lines: {
            show: false
        }
    },   
    yaxis: {
        lines: {
            show: true
        }
    }
};

var strokeOptions = {
    width: 3,
    curve: 'smooth'
}

var fillOptions = {
    opacity: 1,
    type: 'gradient'
}

var axisStyles = {
    fontWeight: 500,
    fontFamily: ['Poppins', 'Montserrat', 'Sans-serif'],
    color: '#3e4044'
}

var options = {
    colors: ["#0061f2"],
    series: [
        {
            name: 'Earnings',
            data: [0, 3000, 1000, 5000, 4000, 7500, 6000, 10000, 9000, 13000, 11500, 15000],
        },
    ],
    chart: chartOoptions,
    grid: gridOptions,
    stroke: strokeOptions,
    fill: fillOptions,
    xaxis: {
        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        labels: {
            style: axisStyles
        }
    },
    yaxis: {
        labels: {
            formatter: function (value) {
                return "$" + value
            },
            style: axisStyles
        }
    },
    dataLabels: {
        enabled: false,
        formatter: function(value){
            return '$' + value;             
        }
    },
    tooltip: {
        followCursor: true,
        shared: true,
        intersect: false,
        y: {
            formatter: function (y) {
                if (typeof y !== "undefined") {
                    return "$" + y.toFixed(0);
                }
                
                return y;
            }
        },
        style: axisStyles
    }
}

var earningsChart = new ApexCharts(document.querySelector("#earnings-chart"), options);
earningsChart.render();