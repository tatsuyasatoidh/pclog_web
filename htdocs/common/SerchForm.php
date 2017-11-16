<?php ini_set( 'display_errors', 1 );
/**
 *検索ボックス
 */
class_exists('lib\Controller\FormController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/FormController.php';

use lib\Controller\FormController as FormController;

/** コントローラ*/
$formController = new FormController($_SESSION["UserId"]);
/** ユーザー選択肢*/
$userOption=$formController->displayUserOption();
/** 企業名選択肢*/
$companyOption=$formController->displayCompanyOption();
/** 閲覧ページの確認*/
$pageType = $formController->checkPage();
?>
<div class="panel panel-primary">
		<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>検索</h3>
		</div>        
		<div>
				<form method="post">
						<?php if($companyOption):?><label>企業名</label><select name="company" id="company" required style="height: 40px;"><?= $companyOption;?></select><?php endif;?>
						<label for="user" >ユーザー</label><select name="user" id="user" required style="height: 40px;"><?= $userOption;?></select>
					<?php if($pageType == "LIST"):?>
						<label>検索開始日</label><input type="date" name="start_date" id="start_date">
						<label>検索終了日</label><input type="date" name="end_date" id="end_date">
					<?php elseif($pageType == "PERSON"):?>
						<label>年月日</label><input type="date" name="date" id="date" required style="height: 40px;">
					<?php endif;?>
						<button id="submit" name="submit" type="submit" class="btn btn-primary" value="submit">検索</button>
				</form>
		</div>
</div>
<script type="text/javascript" charset="utf-8">
    var $jsondata = '<?= json_encode ($_POST);?>'
    var $data = JSON.parse($jsondata);
    $('#company').val($data['company']);
    $('#user').val($data['user']);
    $('#date').val($data['date']);    
</script>