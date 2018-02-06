<?php
include_once $_SERVER ['DOCUMENT_ROOT']."/lib/Controller/Download/Download.php";

class GetLog
{
    private $downLoadManage;
    
    public function __construct()
    {
        $this->downLoadManage = new Download();
    }
    
    /**
     * s3からファイルをダウンロード
     * @param string $key S3のkey
     */
    public function getLogCsv($key)
    {
        try {
            $csvFile = $this->getLogFromS3($key);
        } catch (Exception $e) {
            $csvFile = "";
        }finally{
            return $csvFile;
        }
    }
    
    /*s3からファイルをダウンロード*/
    public function getLogTsv($key)
    {
        try {
            $csvFile = $this->getLogCsv($key);
            $tsvFile = file_get_contents($File);
        /** ,をタブ区切りに変更*/
            $tsvFile = str_replace(",", "\t", $contents);
            file_put_contents($File, $contents);
        } catch (Exception $e) {
            $tsvFile = "";
        }finally{
            return $tsvFile;
        }
    }
    
    private function getLogFromS3($key)
    {
        try {
            $result = $this->downLoadManage->getFromS3($key);
            /** ファイルを出力する */
            //readfile($csvFile);
        } catch (Exception $e) {
            parent::setInfoLog($e->getMessage());
            parent::setInfoLog("S3に該当のファイルがありません。");
        }finally{
            return $result;
        }
    }
}
