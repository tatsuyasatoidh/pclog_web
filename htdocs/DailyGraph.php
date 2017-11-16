<?php 
ini_set( 'display_errors', 1 );
require_once 'common/SessionChecker.php';
class_exists('lib\Controller\DailyGraphController') or require_once $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/DailyGraphController.php';

use lib\Controller\DailyGraphController as DailyGraphController;

/** コントローラ*/
$dailyGraphController = new DailyGraphController($_POST);
/** グラフの作成*/
$graph = $dailyGraphController->createGraph($_POST);
/** */
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
    <link rel="stylesheet" type="text/css" href="css/add.css" />

    <script type="text/javascript" src="js/jquery.js"></script> 
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/datatables/jquery.dataTables.js"></script>
    <script src="js/Charts.js/dist/Chart.Bundle.js"></script>
    <script src="js/Charts.js/utils.js"/></script>
    <script src="js/createGraph.js"/></script>
    <script src="js/errata.js"/></script>

</head>
<body>
<header><?php require_once $_SERVER['DOCUMENT_ROOT'].'/htdocs/common/Header.php';?></header>
<div id="wrapper">
	<div class="row">
			<div class="col-lg-12">
					<h1>時間帯別日間作業量</h1>
			</div>
	</div> 
	
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            メモ　15分グラフテスト。企業名株式会社IDH。ユーザー名satou.tatsuya　年月日　2017/11/04
        </div>
    </div>
</div>
<div class="panel panel-primary">
	<?php require_once 'common/SerchForm.php';?>
</div>
</div>
<?php /** グラフを作成できるのであれば表示*/if($graph):?>
<div class="row" id="15minView">
	<div class="col-lg-4">
		<div class="row">
			<div class="col-lg-12">
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
		</div>
		<div class="row">
			<div class="col-lg-12">
					<div class="panel panel-default ">
							<div class="panel-body alert-info">
									<div class="col-xs-5">
											<i class="fa fa-line-chart fa-5x"></i>
									</div>
									<div class="col-xs-5 text-right">
										<p id="totalWork" class="alerts-heading"></p>
										<span>一日の総作業量</span>
									</div>
							</div>
					</div>
			</div>
		</div>
			<div class="panel panel-primary">
					<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>1時間別グラフ</h3>
					</div>
					<div class="panel-body">
							<canvas id="24Graph" />
					</div>
			</div>
	</div>
	<div class="col-lg-8">
			<div class="panel panel-primary">
					<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>15分別作業量</h3>
					</div>
					<canvas id="canvas" style="width: 100%; height: 10px;"></canvas>
			</div>
	</div>
</div>
<div class="row" id="15minView">
	
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.min.js"></script>

	
<script>
<?php /** グラフのデータが存在するときグラフ作成のJSを呼び出す*/;?>
/** pieチャートの作成(24時間グラフの情報)*/
var $phpGraphInfo_15 ='<?= json_encode($dailyGraphController->getgraphInfoPath_15());?>';
var $phpGraphInfo_60 ='<?= json_encode($dailyGraphController->getgraphInfoPath_60());?>';
var $timeArray = getTimeArray($phpGraphInfo_15);
var $workArray = getWorkArray($phpGraphInfo_15);
var $colorArray = createcolorArray($workArray,900);
	
var ctx = document.getElementById("canvas").getContext('2d');

var original = Chart.defaults.global.legend.onClick;
Chart.defaults.global.legend.onClick = function(e, legendItem) {
  update_caption(legendItem);
  original.call(this, e, legendItem);
};

var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: $timeArray,
    datasets: [{
      label: '作業量',
      backgroundColor:$colorArray,
      data:$workArray,
    }]
  },
	options: barGraphOption()
});

var labels = {
  "apples": true,
  "oranges": true
};

var caption = document.getElementById("caption");

var update_caption = function(legend) {
  labels[legend.text] = legend.hidden;

  var selected = Object.keys(labels).filter(function(key) {
    return labels[key];
  });

  var text = selected.length ? selected.join(" & ") : "nothing";

  caption.innerHTML = "The chart is displaying " + text;
};

var $hourtimeArray = getTimeArray($phpGraphInfo_60);
var $hourworkArray = getWorkArray($phpGraphInfo_60);
var $workArray = getWorkArray($phpGraphInfo_15);
var $hourColorArray = [];
var $hourAchiveArray = [];
var $count =0;
var $achive =0;
var $hourWorkCount =0;
var $dayAchive =0;
for($i = 0; $i <=$workArray.length;$i++){
	$count++;
	if($workArray[$i] > 900){
		$dayAchive++;
		$achive++;
	}
	if($count == 4){
		if($achive== 4){
			$hourAchiveArray[$hourWorkCount] = "○";
			//$hourColorArray[$hourWorkCount] = '#2fa4e7';

		}else{
			$hourAchiveArray[$hourWorkCount] = "×";
			//$hourColorArray[$hourWorkCount] = '#c9c9c9';
		}
		$hourWorkCount++;
		$count = 0;
		$achive = 0;
	}
}
/** pieチャートを二つ作るので分割*/
createWorkPieChartHour($hourworkArray,$hourAchiveArray,$hourtimeArray,"24Graph");
var $achivemin =0;
var $achivehour =0;
if($dayAchive !=0){
	for($i = 0; $i <=$dayAchive;$i++){
		$achivemin= $achivemin+15;
		if($achivemin ==60){
			$achivehour = $achivehour +1;
			$achivemin = 0;
		}
	}
	$dayWork = $achivehour + "時間" + $achivemin + "分";
	$("#attendance").text($dayWork);
	$("#attendance_body").addClass("alert-success");
}else{
	$dayWork = "00時間00分";
	$("#attendance").text($dayWork);
	$("#attendance_body").addClass("alert-danger");
}

//createWorkPieChart($phpGraphInfo_60,"900","15minitues-area_PM","PM");
/** 時間ごとの正誤表を作成（errata）*/
//createWorkPieChartHour($phpGraphInfo_60,"900","hour_grid");
///** 日の作業は目標達成したかを確認*/
// if($attendanceboolean.length >=32){
//    $("#attendance").text("○");
//    $("#attendance_body").addClass("alert-success");
// }else{
//    $("#attendance").text("×");
//    $("#attendance_body").addClass("alert-danger");
// };
</script>
<script>
var $totalWork ='<?= json_encode($dailyGraphController->getTotalWork());?>';
$("#totalWork").text($totalWork);
</script>
<?php 
	/**
	 * 該当するデータがない場合の表示
	 */
	else:?>
<div class="row" id="15minView">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>15分別作業量</h3></div>
					<div class="panel-body">該当のデータはありません</div>
		</div>
	</div>
</div>
<?php endif;?>
<script type="text/javascript" charset="utf-8">
    var $jsondata = '<?= json_encode ($_POST);?>'
    var $data = JSON.parse($jsondata);
    $('#company').val($data['company']);
    $('#user').val($data['user']);
    $('#date').val($data['date']);    
</script>
</body>
</html>