<?php ini_set( 'display_errors', 1 );
require_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Common/autoloader.php';
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
    <script src="js/Charts.js/utils.js"></script>

</head>
<body>
<header><?php require 'common/Header.php';?></header>
<div id="wrapper">
		<div class="row">
				<div class="col-lg-12">
						<h1>時間帯別日間作業量</h1>
				</div>
		</div> 
     
<div class="panel panel-primary">
	<div class="panel-heading">
	   <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>時間帯別日間作業量</h3>
	</div>
<?php
    /*フォームの作成*/
    $formController = new formController();
    $userOption=$formController->getUserOption();
    $companyOption=$formController->getCompanyOption();
?>
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
<?php 
    if(isset($_POST['submit'])):
    $CreateGraph = new CreateGraph();
?>
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
    <?php if($_POST['type'] == '15'):?>
        <?php require_once $_SERVER ['DOCUMENT_ROOT'].'/common/15minGraph.php';?>
    <?php endif;?>
    <?php if($_POST['type'] == '60'):?>   
        <?php require_once $_SERVER ['DOCUMENT_ROOT'].'/common/1hourGraph.php';?>  
    <?php endif;?>  
<?php endif;?>
</div>
<script type="text/javascript" charset="utf-8">
    var $jsondata = '<?= json_encode ($_POST);?>'
    var $data = JSON.parse($jsondata);
    $('#company').val($data['company']);
    $('#user').val($data['user']);
    $('#date').val($data['date']);    
</script>

</body>
</html>