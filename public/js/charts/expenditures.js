var axisStyles = {
    fontFamily: ['Poppins', 'Montserrat', 'Sans-serif'],
    color: '#3e4044'
}

var animationOptions = {
    enabled: true,
    easing: 'easein',
    speed: 800,
    animateGradually: {
        enabled: true,
        // delay: 150
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
                return "$" + separator(y.toFixed(0));
            }
            
            return y;
        }
    },
    style: axisStyles
};

var options = {
    colors: ["#0061f2"],
    series: [],
    noData: {
        text: 'Loading...',
        align: 'center',
        verticalAlign: 'middle'
    },
    title: {
        text: 'Expenditures Breakdown',
        style: {
            fontFamily: ['Poppins', 'Montserrat', 'Sans-serif'],
            fontWeight: 'normal',
            color: '#3e4044'
        }
    },
    xaxis: {},
    yaxis: {
        labels: {
            formatter: function (value) {
                return "$" + initials(value)
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

var el = document.getElementById("expenditures-chart");
var expenditures_chart = new ApexCharts(el, options);
expenditures_chart.render();

axios.get('api/dashboard')
.then((res) => {
    var data = res.data.data.reverse();
    var months = res.data.months;

    expenditures_chart.updateOptions({
        series: [{
            name: 'Expenditures',
            data: data
        }],
        xaxis: {
            categories: months, // import
            labels: {
                style: axisStyles,
            }
        }
    });
});