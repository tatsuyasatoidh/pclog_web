<?php session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面＿PcLogTool</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="css/local.css" />
    <link rel="stylesheet" type="text/css" href="css/add.css" />
    <script type="text/javascript" src="js/jquery.js"></script> 
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/datatables/jquery.dataTables.js"></script>
    <script src="js/Charts.js/dist/Chart.Bundle.js"></script>
    <script src="js/Charts.js/utils.js"></script>
<style>
	.center_box{
		margin-left: auto;
		margin-right: auto;
		text-align: center;
		border: 1px solid #eee;
	}
</style>
</head>
<body>
<div id="container">
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="navbar-header">
	<a class="navbar-brand">PcLogTool</a>
	</div>
</nav>
	<div class="col-lg-12 text-center v-center">
		<h3>ログアウトしました。</h3>
		<br>
		<a href="login.php">ログイン画面</a>
	</div>
	</div>
</div>
</body>
</html>