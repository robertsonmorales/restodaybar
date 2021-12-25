var animations = {
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

var chartOptions = {
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
    fontFamily: ['Poppins', 'Montserrat', 'Sans-serif'],
    color: '#3e4044'
}

var options = {
    colors: ["#4caf50"],
    series: [],
    noData: {
        text: 'Loading...',
        align: 'center',
        verticalAlign: 'middle'
    },
    title: {
        text: 'Revenue Breakdown',
        style: {
            fontFamily: ['Poppins', 'Montserrat', 'Sans-serif'],
            fontWeight: 'normal',
            color: '#3e4044',
        }
    },
    chart: chartOptions,
    grid: gridOptions,
    stroke: strokeOptions,
    fill: fillOptions,
    xaxis: {},
    yaxis: {
        labels: {
            formatter: function (value) {
                return "$" + initials(value)
            },
            style: axisStyles
        }
    },
    dataLabels: { 
        enabled: false,
        formatter: function(value){
            return '$' + separator(value);             
        }
    },
    tooltip: {
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
    }
};

var el = document.getElementById("revenue-chart");
var revenue_chart = new ApexCharts(el, options);
revenue_chart.render();

axios.get('api/dashboard')
.then((res) => {
    var data = res.data.data;
    var months = res.data.months;

    revenue_chart.updateOptions({
        series: [{
            name: 'Revenue',
            data: data, // import
        }],
        xaxis: {
            categories: months, // import
            labels: {
                style: axisStyles,
            }
        }
    })
});

function separator(data){
    return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function initials(val){
    var unit = '';
    if(val != ""){
        
        var new_val = separator(val);
        var place_value = new_val.split(',');           

        if (place_value.length == 1) {
            unit = '';
        }

        if (place_value.length == 2) {
            unit = 'K';
        }

        // if(place_value.length == 3){
        //     unit = 'M';
        // }

        // if(place_value.length == 4){
        //     unit = 'B';
        // }

        var get_initial = place_value[0];
        var new_initials;
        var new_second_initial;

        if(place_value.length < 2){
            new_initials = get_initial;
        }else{
            var get_second_initial = place_value[1]; // with .5M

            if(get_second_initial.split('')[0] != 0){
                new_second_initial = get_second_initial.split('')[0];
                
                new_initials = get_initial + '.' + new_second_initial + 'M';
            }else{
                new_initials = get_initial + unit;
            }
        }

        return new_initials;
    }

    return 0;
}