<?php
/*
* クリックしてcsvをダウンロードするphp
*/
ini_set( 'display_errors', 1 );

include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Controller/Download/Download.php";

$downLoad = new Download();
$csvFile = $downLoad->getLogCsv($_GET['log_path']);
if($csvFile !=""{
    /*ローカルにファイルをダウンロード*/
    $downLoad->toLocal($csvFile);
}

?>