<?php
require('lib/ViewCommon/CreateGraph.php');
require('lib/ViewCommon/ValueCheck.php');

$CreateGraph= new CreateGraph();	
if(isset($_POST['submit'])){
	$val['company']=$_POST['company'];
	$val['user']=$_POST['user'];
	$val['month']=$_POST['month'];	
}else{
	$val['company']="";
	$val['user']="";
	$val['month']="";
}
	$dataPoints = $CreateGraph->monthGraph($val);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PcLogTool</title>

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="css/local.css" />

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

    <!-- you need to include the shieldui css and js assets in order for the charts to work -->
    <link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light-bootstrap/all.min.css" />
    <script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
    <script type="text/javascript" src="http://www.prepbootstrap.com/Content/js/gridData.js"></script>
</head>
<body>
<header><?php require('common\Header.php');?></header>
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
		<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>　さんの　月　日　の作業量</h3>
		</div>
		<form method="post">
			<label>企業名</label><input type="text" name="company" value="<?php echo $val['company'] ;?>">
			<label for="user" >ユーザー</label><input type="text" name="user" id="user" value="<?php echo $val['user'] ;?>">
			<label>年月日</label><input type="month" name="month" value="<?php echo $val['month'] ;?>">
			<button id="submit" name="submit" type="submit" class="btn btn-primary" value="submit">検索</button>
		</form>
		</div>
	</div>
	<div class="col-lg-12">
	<div class="panel">
	<div class="panel-heading">
	<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>　さんの　月　日　の作業量</h3>
	</div>
	<div class="panel-body">
	<div id="chartContainer"></div>
	</div>
	</div>
	</div>
	</div>

	</div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="lib/canvas/canvasjs.min.js"></script>
<script type="text/javascript">
		$(function () {
				var chart = new CanvasJS.Chart("chartContainer", {
						theme: "theme2",
						animationEnabled: true,
						title: {
								text: "日別月間グラフ"
						},
						data: [
						{
								type: "column",                
								dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
						}
						]
				});
				chart.render();
		});
</script>
</body>
</html>