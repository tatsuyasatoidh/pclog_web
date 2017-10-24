<?php
namespace lib\Service\HttpRequest;

require_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Service/HttpRequest/S3.php';
class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';

use lib\Controller\ParentController as ParentController;

class Download extends ParentController{
    
    public function __construct(){
    }
    
    /*ファイルをローカルにダウンロード**/
    public function toLocal($File){
		
        parent::setInfoLog("toLocal START");
        /* File Read */
        $read_data = file_get_contents($File);
        $fileName = basename($File);
        $path =parent::appendStr($path,".csv");
        /* Output HTTP Header */
        header('Content-Disposition: inline; filename="'.$fileName.'"');
        header('Content-Type: application/octet-stream');
		
    }
	
	/** S3からファイルをダウンロードする処理*/
	public function getFromS3($path)
	{
		parent::setInfoLog("getFromS3 START");
		$s3Manage = new S3Request();
		parent::setInfoLog("getFromS3 END");
		#ローカルに取得
		return $s3Manage->getFile($path);
	}
}