var axisStyles = {
    fontWeight: 500,
    fontFamily: ['Poppins', 'Montserrat', 'Sans-serif'],
    color: '#3e4044'
}

var animationOptions = {
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
    type: 'bar',
    stacked: true,
    markers: {
        size: 3,
    },
    animations: animationOptions,
    toolbar: {
        show: false,
    }
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
    show: false,
    // opacity: 1,
    // type: 'gradient'
}

var dataLabelsOptions = {
    enabled: false,
    formatter: function(value){
        return '$' + value;             
    }
};

var tooltipOptions = {
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
};

var options = {
    colors: ["#0061f2"],
    series: [
        {
            name: 'Revenue',
            data: [100, 3000, 1000, 5000, 7000, 4000, 5000, 7300, 2000, 13300, 5000, 14000],
        },
    ],
    xaxis: {
        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        labels: {
            style: axisStyles,
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
    chart: chartOoptions,
    grid: gridOptions,
    stroke: strokeOptions,
    fill: fillOptions,
    dataLabels: dataLabelsOptions,
    tooltip: tooltipOptions
}

var revenueChart = new ApexCharts(document.querySelector("#revenue-chart"), options);
revenueChart.render();