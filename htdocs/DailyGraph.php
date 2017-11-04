<?php ini_set( 'display_errors', 1 );
class_exists('lib\Controller\DailyGraphController') or require_once $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/DailyGraphController.php';

use lib\Controller\DailyGraphController as DailyGraphController;

/** コントローラ*/
$dailyGraphController = new DailyGraphController();
/** ユーザー選択肢*/
$userOption=$dailyGraphController->displayUserOption();
/** 企業名選択肢*/
$companyOption=$dailyGraphController->displayCompanyOption();
/** グラフの作成*/
$graph = $dailyGraphController->createGraph($_POST);
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
<header><?php require_once $_SERVER['DOCUMENT_ROOT'].'/htdocs/Header.php';?></header>
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
<div class="panel-heading">
	<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>時間帯別日間作業量</h3>
</div>
<div>
	<form method="post">
			<label>企業名</label><select name="company" id="company" required style="height: 40px;"><?= $companyOption;?></select>
			<label for="user" >ユーザー</label><select name="user" id="user" required style="height: 40px;"><?= $userOption;?></select>
			<label>年月日</label><input type="date" name="date" id="date" required style="height: 40px;">
			<label>間隔</label><select name="type" id=""><option value="15" required style="height: 40px;">15分間</option><option value="60">1時間</option></select>
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
</div>
<?php /** グラフを作成できるのであれば表示*/if($graph):?>
<!--
	<div class="row">
			<div class="col-lg-4">
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
					<div class="col-lg-4">
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
-->
<div class="row" id="15minView">
	<div class="col-lg-3">
			<div class="panel panel-primary">
					<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>15分別作業量(午前)</h3>
					</div>
					<div class="panel-body">
							<canvas id="15minitues-area_AM" />
					</div>
			</div>
	</div>
	<div class="col-lg-3">
			<div class="panel panel-primary">
					<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>15分別作業量(午後)</h3>
					</div>
					<div class="panel-body">
							<canvas id="15minitues-area_PM" />
					</div>
			</div>
	</div>
	<div class="col-lg-6">
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
<div class="row" id="15minView">
	<div class="col-lg-12">
			<div class="panel panel-primary">
					<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>折れ線グラフ</h3>
					</div>
				<canvas id="Line_graph" />
			</div>
	</div>
</div>
<script>
/** pieチャートの作成*/
var $phpGraphInfo ='<?= json_encode($dailyGraphController->getGraphInfo());?>';

/** pieチャートを二つ作るので分割*/
createWorkPieChart($phpGraphInfo,"900","15minitues-area_AM","AM");
createWorkPieChart($phpGraphInfo,"900","15minitues-area_PM","PM");
/** 時間ごとの正誤表を作成（errata）*/
createErrata($phpGraphInfo,"900","hour_grid");
///** 日の作業は目標達成したかを確認*/
// if($attendanceboolean.length >=32){
//    $("#attendance").text("○");
//    $("#attendance_body").addClass("alert-success");
// }else{
//    $("#attendance").text("×");
//    $("#attendance_body").addClass("alert-danger");
// };
</script>
<?php else:?>
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