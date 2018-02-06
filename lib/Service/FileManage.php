<?php
namespace lib\Service;

class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';

use lib\Controller\ParentController as ParentController;

 /*
 * ファイルに関するクラス
 */
class FileManage extends ParentController
{
     /*
     * csvファイルを配列にする
     * @return  array 配列
     */
    public function csvToArray($csvFile)
    {
        try {
                parent::setInfoLog("csvToArray START");
                parent::setInfoLog("csvFile is $csvFile");
            
            if (!file_exists($csvFile)) {
                throw new \Exception("csvファイルは存在しません（${csvFile})");
            }
                $filepath = str_replace('.csv.csv', '.csv', $csvFile);
                $csvArray  = array();
                $fp   = fopen($filepath, "r");
            while (($data = fgetcsv($fp, 0, ",")) !== false) {
                $csvArray[] = $data;
            }
                fclose($fp);
        } catch (\Exception $e) {
            parent::setInfoLog($e->getMessage());
            $csvArray = null;
        }finally{
            parent::setInfoLog("csvToArray END");
            return $csvArray;
        }
    }
}
