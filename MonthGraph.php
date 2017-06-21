<?php
require_once 'lib/CreateFigure/CreateGraph.php';
require 'lib/ViewCommon/ValueCheck.php';

$CreateGraph= new CreateGraph();	

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>日別月間作業量|PcLogTool</title>

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
						<h1>日別月間作業量 <small>MonthGraph</small></h1>
				</div>
		</div> 
	<div class="panel panel-primary">
			<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>日別月間作業量</h3>
			</div>
			<div class="panel-body">
			<div class="col-lg-12">
				<div class="panel">
				<div class="panel-heading">
				</div>
				<form method="post">
					<label>企業名</label><input type="text" name="company" required>
					<label for="user" >ユーザー</label><input type="text" name="user" id="user" required>
					<label>年月日</label><input type="month" name="month" required>
					<button id="submit" name="submit" type="submit" class="btn btn-primary" value="submit">検索</button>
				</form>
				</div>
			</div>
			</div> <canvas id="canvas" style="height:20px"></canvas>
	</div>
	</div>
	</div>
<?php if(isset($_POST['submit'])):
    if($CreateGraph->monthGraph($_POST)):?>
    <script>
    var $monthjsondata ='<?= json_encode($CreateGraph->getResult());?>';
    var $monthdata =JSON.parse($monthjsondata);
    var $workdata = $monthdata["work"];
    var $datetime = $monthdata["date"];
    var color = Chart.helpers.color;
    var horizontalBarChartData = {
        labels: $datetime,
        datasets: [{
            label: '作業量',
            backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
            borderColor: window.chartColors.red,
            borderWidth: 1,
            data: $workdata
        }, ],
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
<?php endif;?>
</body>
</html>