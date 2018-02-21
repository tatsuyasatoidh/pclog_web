$(function () {
    /** サンプルデータ*/
    var data = mounthData;

    function createLabel(data,key){
        label = [];
        for(i = 0; i < data.length;i++){
            label.push(data[i][key]);
        }
        return label;
    }
    
    function createWork(data,key){
        array = [];
        for(i = 0; i < data.length;i++){
            array.push(data[i][key]);
        }
        return array;
    }
    
    var label = createLabel(data,'date');
    var workData = createWork(data,"work");
    
    /**
     * datatables
     **/
    $('#example1').DataTable( {
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        displayLength: 31,
        scrollY: 300,
        data: data,
        columns: [
            { data: 'date' },
            { data: 'work' },
            { data: 'progress' },
            { data: 'status' }
        ]
    } );

    /** Line */
    var LineChartCanvas                   = $('#LineChart').get(0).getContext('2d')
    var LineChart                         = new Chart(LineChartCanvas)
    var LineChartData                     = {
        labels  : label,
        datasets: [
            {
                label               : 'Digital Goods',
                fillColor           : 'rgba(60,141,188,0.9)',
                strokeColor         : 'rgba(60,141,188,0.8)',
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : workData
            }
        ]
    }
    LineChartData.datasets[0].fillColor   = '#00a65a'
    LineChartData.datasets[0].strokeColor = '#00a65a'
    LineChartData.datasets[0].pointColor  = '#00a65a'
    var LineChartOptions                  = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero        : true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines      : true,
        //String - Colour of the grid lines
        scaleGridLineColor      : 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth      : 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines  : true,
        //Boolean - If there is a stroke on each Line
        LineShowStroke           : true,
        //Number - Pixel width of the Line stroke
        LineStrokeWidth          : 100,
        //Number - Spacing between each of the X value sets
        LineValueSpacing         : 5,
        //Number - Spacing between data sets within X values
        LineDatasetSpacing       : 1,
        //String - A legend template
        legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        //Boolean - whether to make the chart responsive
        responsive              : true,
        maintainAspectRatio     : true,
        tooltipTemplate      : ' 作業日 ： <%=label%>　作業量 ： <%=value %>'
    }

    LineChartOptions.datasetFill = false
    LineChart.Line(LineChartData, LineChartOptions)
})