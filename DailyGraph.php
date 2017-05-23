<?php
require('lib/ViewCommon/CreateGraph.php');
require('lib/ViewCommon/ValueCheck.php');
ini_set( 'display_errors', 1 );
$CreateGraph= new CreateGraph();	
if(isset($_POST['submit'])){
	$val['company']=$_POST['company'];
	$val['user_name']=$_POST['user_name'];
	$val['date']=$_POST['date'];
	$val['interval']=$_POST['interval'];
	
}else{
	$val['company']="";
	$val['user_name']="";
	$val['date']="";
	$val['interval']="";
}
	$dataPoints=$CreateGraph->dailyGraph($val);

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

    <script type="text/javascript" src="lib/jquery/jquery-3.1.1.min.js"></script>
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
						<h1>時間帯別日間作業量 <small>Dashboard Home</small></h1>
				</div>
		</div> 
<div class="panel panel-primary">
	<div class="panel-heading">
	<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>時間帯別日間作業量</h3>
	</div>
	<div class="panel-body">
	<div class="col-lg-12">
	<div class="panel">
	<div class="panel-heading">
	<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>　さんの　月　日　の作業量</h3>
	</div>
		<form method="post">
			<label for="company">企業名</label><input type="text" name="company" value="<?php echo $val['company'] ;?>">
			<label for="user_name" >ユーザー</label><input type="text" name="user_name" id="user_name" value="<?php echo $val['user_name'] ;?>" required>
			<label>年月日</label><input type="date" name="date" value="<?php echo $val['date'] ;?>" required>
			<label>表示間隔</label>
			<select name="interval">
				<option value="15m">15分間隔</option>
				<option value="30m">30分間隔</option>
				<option value="1h">1時間隔</option>
			</select>
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
	</div><?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	</div>
</div>
    <!-- /#wrapper -->
<?php if($dataPoints!=NULL): ?>
		<script src="lib/canvas/canvasjs.min.js"></script>
		<script type="text/javascript" async>
				$(function () {
						CanvasJS.addColorSet("pieColor",<?php echo json_encode($dataPoints['color'], JSON_NUMERIC_CHECK); ?>);
						<?php unset($dataPoints['color']);?>
						var chart = new CanvasJS.Chart("chartContainer",
						{
								theme: "theme2",
								title:{
										text: <?php echo json_encode($dataPoints['title'], JSON_NUMERIC_CHECK); ?>
								},
								colorSet: "pieColor",
								exportFileName: "New Year Resolutions",
								exportEnabled: true,
								animationEnabled: true,
								<?php unset($dataPoints['title']);?>
								data: [
								{       
										type: "pie",
										indexLabelPlacement: "inside", 
										toolTipContent: "{name}",
										startAngle:-90, 
										dataPoints: 
								}]
						});
						chart.render();
				});
		</script>
<?php else:?>
	<script type="text/javascript">$('#chartContainer').text("該当データがありません。");</script>
<?php endif;?>
</body>
</html>