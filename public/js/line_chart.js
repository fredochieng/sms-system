$(function () {
    // LINE CAHRT
    Chart.defaults.scale.gridLines.display = false;
    var options = {
        type: 'line',
        data: {
            labels: < ? php echo $all_dates; ? > ,
            datasets : [{
                    label: 'Sent',
                    borderColor: '#00a65a',
                    fillColor: 'rgb(218, 107, 222)',
                    strokeColor: 'rgb(218, 107, 222)',
                    gridLines: false,
                    pointColor: 'rgb(218, 107, 222)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    // data                : [20, 48, 85, 87, 73, 56, 43, 13, 25, 43, 37, 36, 36, 34, 12]
                    data: < ? php echo $all_sent; ? >
                },
                {
                    label: 'Delivered',
                    borderColor: '#00c0ef',
                    gridLines: false,
                    fillColor: 'rgba(60,141,188,0.9)',
                    strokeColor: 'rgba(60,141,188,0.8)',
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [435, 674, 433, 834, 644, 433, 865, 453, 537, 758, 543, 452, 734, 136, 537]
                    // data                : [<?jjphp echo $all_delivered; ?kk>]
                },
                {
                    label: 'Failed',
                    borderColor: '#bb2124',
                    gridLines: false,
                    fillColor: 'rgba(60,141,188,0.9)',
                    strokeColor: 'rgba(60,141,188,0.8)',
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [435, 645, 645, 688, 547, 234, 188, 435, 536, 452, 523, 534, 637, 745, 454]
                    //data                : <?ggphp echo $all_failed; ?hh>
                },
                {
                    label: 'Pending',
                    borderColor: 'yellow',
                    gridLines: false,
                    fillColor: 'rgba(60,141,188,0.9)',
                    strokeColor: 'rgba(60,141,188,0.8)',
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [635, 647, 535, 764, 235, 646, 122, 535, 425, 425, 523, 535, 623, 233, 232]
                    // data                : <?hhphp echo $all_pending; ?hh>
                }

            ]
        },


    }

    var ctx = document.getElementById('chartJSContainer').getContext('2d');
    new Chart(ctx, options);

});