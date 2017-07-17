<?php
include_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Common/ParentController.php';
require_once $_SERVER ['DOCUMENT_ROOT'].'/lib/HttpRequest/S3.php';
class Download extends ParentController{
    
    public function __construct(){
    }
    
    /*s3からファイルをダウンロード*/
    public function getLogCsv($path){
        $path .=".csv"; 
        $path = str_replace('.csv.csv','.csv',$path);
        try{
            parent::setInfoLog($path);
            $s3Manage = new S3Request();
            #ローカルに取得
            $csvFile = $s3Manage->getFile($path);
            
        }catch(Exception $e){
            parent::setInfoLog($e->getMessage());
            parent::setInfoLog("S3に該当のファイルがありません。");
            $csvFile = "";
        }finally{
            return $csvFile;
        }
    }
    
    /*ファイルをローカルにダウンロード**/
    public function toLocal($File){
        /* File Read */
        $read_data = file_get_contents($File);
        $fileName = str_replace('/','_',$_GET['log_path']).".csv";
        $fileName = str_replace('.csv.csv','.csv',$fileName);
        /* Output HTTP Header */
        header('Content-Disposition: inline; filename="'.$fileName.'"');
        header('Content-Type: application/octet-stream');
    }
    
}