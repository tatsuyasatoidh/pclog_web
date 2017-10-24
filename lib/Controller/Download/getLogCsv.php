<?php
ini_set( 'display_errors', 1 );
/*
* クリックしてcsvをダウンロードするphp
*/
include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Service/HttpRequest/Download.php";

use lib\Service\HttpRequest\Download as Download;

function getLogcsv($path)
{
	try{
		$downLoadManage = new Download();
		$downLoadManage->getFromS3($path);
	}catch(Exception $e){
		echo "s3からのダウンロードに失敗しました";
	}
}

getLogcsv($_GET['log_path']);

?>