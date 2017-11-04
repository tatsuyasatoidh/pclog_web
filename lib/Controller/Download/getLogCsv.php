<?php
ini_set( 'display_errors', 1 );
/*
* クリックしてcsvをダウンロードするphp
*/
include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Service/HttpRequest/Download.php";

use lib\Service\HttpRequest\Download as Download;

function getLogcsv($key)
{
	try{
		$downLoadManage = new Download();
		$key = $key.".csv";
		$outputPath = "/tmp/".$key;
		$downLoadManage->getFromS3($outputPath,$key);
		$downLoadManage->toLocal($outputPath);
	}catch(Exception $e){
		echo "s3からのダウンロードに失敗しました";
	}
}

getLogcsv($_GET['log_path']);

?>