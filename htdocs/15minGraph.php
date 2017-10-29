 <div class="row" id="15minView">
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>15分別作業量</h3>
            </div>
            <div class="panel-body">
                <canvas id="1hourchart-area" />
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>15分別作業量</h3>
            </div>
           <div id="canvas-holder" style="height: 270px;overflow-y: scroll;">
                <table id="hour_grid"><tr><th>時間</th><th>作業量</th><th>勤務</th></tr></table>
            </div>
        </div>
    </div>
</div>
<script>
var $hourjsondata ='<?= json_encode($Graph->getResult());?>';
var $hourdata =JSON.parse($hourjsondata);
var $workdata = $hourdata["work"];
var $timedata = $hourdata["time"];
var $colorArray = [];
var $attendanceArray = [];
    $workdata.forEach(function($val){
        var $colorData =(($val >= 900)?'#044C92':'gray');      
        var $attendance =(($val >= 900)?'○':'×');      
        $colorArray.push($colorData);
        $attendanceArray.push($attendance);
    });
var config = {
    type: 'pie',
    data: {
        datasets: [{
            data: [
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,

                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,

                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,

                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
                10,10,10,10,
            ],
            backgroundColor:$colorArray,
        }],
        labels: [
            $timedata
        ]
    },
   
    options: {
        responsive: true,
         legend: {
            display: false
     },
        tooltips: {
        mode: false
        },
    }
};
    var ctx = document.getElementById("1hourchart-area").getContext("2d");
    window.myPie = new Chart(ctx, config);

var colorNames = Object.keys(window.chartColors);

var $attendanceboolean = [];
for($i = 0; $i<96;$i++){
    $("#hour_grid").append("<tr><td>" + $timedata[$i] + "</td><td>" + $workdata[$i] + "</td><td>"+$attendanceArray[$i]+"</td></tr>");
    if($attendanceArray[$i] == "○"){
        $attendanceboolean.push("○");
    }
   
 }
    
 if($attendanceboolean.length >=32){
    $("#attendance").text("○");
    $("#attendance_body").addClass("alert-success");
 }else{
    $("#attendance").text("×");
    $("#attendance_body").addClass("alert-danger");
 };
</script>
<script>
    $("#15minView").children().remove();
    $("#15minView").append('<div class="col-lg-12"><div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>15分別作業量</h3></div><div class="panel-body">該当のデータはありません</div></div>');
</script>

<?php endif;?>