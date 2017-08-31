<?php 
ini_set( 'display_errors', 1 );
require('lib/ViewCommon/ListTable.php');
require('lib/ViewCommon/ValueCheck.php');
$ListTable=new ListTable();
if(isset($_POST['submit'])){
	$val['company']=$_POST['company'];
	$val['user']=$_POST['user'];
	$val['start_date']=$_POST['start_date'];
	$val['end_date']=$_POST['end_date'];
	
}else{
	$val['company']="";
	$val['user']="";
	$val['start_date']="";
	$val['end_date']="";
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Deep Blue Admin</title>

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="css/local.css" />

    <script type="text/javascript" src="js/jquery.js"></script> 
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

    <!-- you need to include the shieldui css and js assets in order for the charts to work -->
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
                    <h1>一覧 <small>Dashboard Home</small></h1>
                </div>
            </div> 
						<div class="panel panel-primary">
								<div class="panel-heading">
										<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>検索</h3>
								</div>        
<?php
/*フォームの作成*/
$formController = new formController();
$userOption=$formController->getUserOption();
$companyOption=$formController->getCompanyOption();
?><div>
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
				<div class="panel-body">
						<table id="log_table" style="width: 100%;"><?php $ListTable->pcLogList($val);?></table>
				</div>
		</div>
    </div>
<!-- /#wrapper -->
<!-- you need to include the shieldui css and js assets in order for the charts to work -->
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