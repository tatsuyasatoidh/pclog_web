<?php 
require_once 'lib/CreateFigure/CreateGraph.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>時間帯別日間作業量＿PcLogTool</title>

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="css/local.css" />

    <script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/datatables/jquery.dataTables.js"></script>
<script src="js/Charts.js/dist/Chart.Bundle.js"></script>
    <script src="js/Charts.js/utils.js"></script>

</head>
<body>
<header><?php require 'common/Header.php';?></header>
<div id="wrapper">
		<div class="row">
				<div class="col-lg-12">
						<h1>時間帯別日間作業量 <small>Dashboard Home</small></h1>
				</div>
		</div> 
     
<div class="panel panel-primary">
	<div class="panel-heading">
	<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>時間帯別日間作業量</h3>
	</div>
        <div>
            <form method="post">
                <label>企業名</label><input type="text" name="company" id="company">
                <label for="user" >ユーザー</label><input type="text" name="user" id="user">
                <label>年月日</label><input type="date" name="date" id="date">
                <button id="submit" name="submit" type="submit" class="btn btn-primary" value="submit">検索</button>
            </form>
        </div>
    </div>
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            ・15分間で900回の操作があるものは、その15分間は業務をしていたものとみなす。（判定○）<br>
            ・1日の労働時間を8時間とすると、15分間隔は32回ある。<br>
            ・つまり、32回の○があって、その日は業務をしていたものとする。<br>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default ">
            <div id="attendance_body" class="panel-body">
                <div class="col-xs-5">
                    <i class="fa fa-briefcase fa-5x"></i>
                </div>
                <div class="col-xs-5 text-right">                
                    <p id="attendance" class="alerts-heading"></p>
                </div>
            </div>
        </div>
    </div>
        <div class="col-lg-6">
        <div class="panel panel-default ">
            <div class="panel-body alert-info">
                <div class="col-xs-5">
                    <i class="fa fa-line-chart fa-5x"></i>
                </div>
                <div class="col-xs-5 text-right">
                    <p id="total_work" class="alerts-heading"></p>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div class="row">
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

    
      <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>一時間別作業量</h3>
                        </div>
                        <div class="panel-body">
                            <canvas id="canvas" style="height:20px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
    

    

<?php 
    if(isset($_POST['submit'])):
    $CreateGraph = new CreateGraph();
?>
<script type="text/javascript" charset="utf-8">
    var $jsondata = '<?= json_encode ($_POST);?>'
    var $data = JSON.parse($jsondata);
    $('#company').val($data['company']);
    $('#user').val($data['user']);
    $('#date').val($data['date']);    
</script>
    
<script>
<?php if($CreateGraph->fifteenthMin($_POST)):?>
var $hourjsondata ='<?= json_encode($CreateGraph->getResult());?>';
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
<?php endif;?>
    
    
    
    
<?php if($CreateGraph->hourhMin($_POST)):?>
    <script>
    var $fifteenthjsondata ='<?= json_encode($CreateGraph->getResult());?>';
    var $fifteenthdata =JSON.parse($fifteenthjsondata);
    var $workdata = $fifteenthdata["work"];
    var $timedata = $fifteenthdata["time"];
    var color = Chart.helpers.color;
    var horizontalBarChartData = {
        labels: $timedata,
        datasets: [{
            label: '作業量',
            backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
            borderColor: window.chartColors.red,
            borderWidth: 1,
            data: $workdata
        }, ],
        title: {
            display: true,
            text: '15分別作業量'
        },
    };
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myHorizontalBar = new Chart(ctx, {
                type: 'bar',
                data: horizontalBarChartData,
                options: {
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                        }
                    },
                    responsive: true,
                    legend: {
                        position: 'right',
                    },
                    height: 60,
                }
            });
    </script>
<?php endif;?>
<script>
/* 検索日の総作業量 */
var $total_work = <?= $CreateGraph->getTotalWork();?>;
$("#total_work").text("<?= $CreateGraph->getTotalWork();?>");
</script>    

<?php 
    endif;
?>        
    
</html>