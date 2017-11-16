<?php session_start();
ini_set( 'display_errors', 1 );
class_exists('lib\Controller\LoginController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/LoginController.php';
use lib\Controller\LoginController as LoginController;

$loginController = new LoginController($_POST);

if(isset($_POST['submit'])){
    /** passwordとメールアドレスがMYSQLにあるか*/
	$userId = $loginController->getUserId();
    /** passwordとメールアドレスが一致したらログイン*/
    if($userId){
        $_SESSION["UserId"] = $userId;
        $_SESSION["Login"] = "ON";
        header('Location:LogList.php');
    }else{
			
		}
}
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
	<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            テスト社員　test@gmail.com　idhtest<br>
					  IDHテスト社員　idhtest@mail.com idhtest　
        </div>
    </div>
</div>
	<div class="col-lg-12 text-center v-center">
		<h1>ログイン</h1>
		<?php if(isset($loginController)):?>
			<?php foreach ($loginController->getErrorMessage() as $message):?>
				<p class="alert-warning"><?= $message;?></p>
			<?php endforeach;?>
		<?php endif;?>
		<br>
		<form class="col-lg-12" method="post">
			<div class="input-group" style="width: 340px; text-align: center; margin: 0 auto;">
				<input class="form-control input-lg" title="Confidential signup."
					placeholder="email" type="text" name="email" required value="test@gmail.com"><br>
				<input class="form-control input-lg" title="Confidential signup."
					placeholder="password" type="text" name="password" required value="idhtest"><br>
				<input class="btn btn-lg btn-primary" type="submit" value="LOGIN" name="submit">
			</div>
		</form>
	</div>
	</div>
</div>
</body>
</html>