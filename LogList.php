<?php 
ini_set( 'display_errors', 1 );
require_once('lib/ViewCommon/ValueCheck.php');

class_exists('lib\Controller\Form\FormController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/Form/FormController.php';
class_exists('lib\Controller\LogListController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/LogListController.php';

use lib\Controller\Form\FormController as FormController;
use lib\Controller\LogListController as LogListController;

/*フォームの作成　*/
$formController = new FormController();
/** コントローラ　*/
$logListController=new LogListController();
/** ログリストテーブルを作成*/
$logTable = $logListController->getLogList($_POST);
/** userセレクト*/
$userOption=$formController->getUserOption();
/** 企業セレクト*/
$companyOption=$formController->getCompanyOption();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログ一覧画面</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="css/local.css" />
    <script type="text/javascript" src="js/jquery.js"></script> 
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light-bootstrap/all.min.css" />
    <script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
    <script type="text/javascript" src="js/datatables/jquery.dataTables.js"></script>
</head>
<body>
    <div id="wrapper">
			<header>
					<?php include_once dirname(__FILE__)."/common/Header.php";?>
			</header>
			<div class="row">
					<div class="col-lg-12">
							<h1>ログファイル一覧 <small>Dashboard Home</small></h1>
					</div>
			</div> 
			<div class="panel panel-primary">
					<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>検索</h3>
					</div>        
					<div>
							<form method="post">
									<label>企業名</label><select name="company" id="company" required style="height: 40px;"><?= $companyOption;?></select>
									<label for="user" >ユーザー</label><select name="user" id="user" required style="height: 40px;"><?= $userOption;?></select>
									<label>年月日</label><input type="date" name="start_date" id="start_date">
									<label>年月日</label><input type="date" name="end_date" id="end_date">
									<button id="submit" name="submit" type="submit" class="btn btn-primary" value="submit">検索</button>
							</form>
					</div>
			</div>
			<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>検索</h3>
					</div>
					<div class="panel-body"><?= $logTable;?></div>
			</div>
    </div>
<script type="text/javascript" src="js/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $('#log_table').DataTable();
        });
</script>
    
<script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $('#log_table').DataTable();
        });
</script>
        
<?php 
    /*フォームの値の復元*/
    if(isset($_POST['submit'])):
?>
<script type="text/javascript" charset="utf-8">
    var $jsondata = '<?= json_encode ($_POST);?>'
    var $data = JSON.parse($jsondata);
    $('#company').val($data['company']);
    $('#user').val($data['user']);
    $('#start_date').val($data['start_date']);
    $('#end_date').val($data['end_date']);    
</script>
<?php 
    endif;
?>    
</body>
</html>