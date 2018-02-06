<?php
namespace lib\Dao;

class_exists('lib\Dao\ParentDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/ParentDao.php';
include_once dirname(__FILE__).'/../Entity/TmpLog.php';

class TmpLogDao extends ParentDao
{
  
    private $tableName = "tmp_log";

    /** コンストラクタ*/
    public function __construct($userId, $date)
    {
        $date = date('Ymd', strtotime($date));
        $this->tableName ="tmp_log_".$userId."_".$date;
    }

    /*
    * tmplogを削除
    * ファイルからデータを取得する前に一度初期化してデータのずれを防ぐ
    */
    public function emptyTable()
    {
        try {
                   $qy = " DELETE FROM `$this->tableName` WHERE 1=1";
                   parent::setInfoLog($qy);
                   $result=parent::commitStmt($qy);
        } catch (Exception $e) {
             parent::setInfoLog($e->getMessage());
        } finally {
             return $result;
        }
    }
    
    /*
    * テーブルの作成
    * @access public
    */
    public function createTable()
    {
        try {
                    $qy = "CREATE TABLE `$this->tableName` (
								`user_name` varchar(255) NOT NULL,
								`date` date NOT NULL,
								`time` time NOT NULL,
								`key` varchar(255) NOT NULL,
								`work` int(11) NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8";
                    $result=parent::commitStmt($qy);
        } catch (Exception $e) {
            parent::setInfoLog($e->getMessage());
        } finally {
                     return $result;
        }
    }
    
    public function loadDataCsv($csvFilePath)
    {
        $this->emptyTable();
        $qy="LOAD DATA LOCAL INFILE '$csvFilePath' INTO TABLE `$this->tableName` FIELDS TERMINATED BY ','";
        $result=parent::commitStmt($qy);
    }
    
    public function getSumWorks($unitType)
    {
        try {
               parent::setInfoLog("getSumWorks START");
               parent::setInfoLog("type is $unitType");
               $result ="";
               $resultArray="";
            if ($unitType=='15') {
                #15分
                $qy="select SUM(work) AS work,from_unixtime(round(unix_timestamp(time) div (15 * 60)) * (15 * 60)) AS timekey from $this->tableName group by timekey";
            } elseif ($unitType=='30') {
                #30分
                $qy="select SUM(work) AS work,from_unixtime(round(unix_timestamp(time) div (30 * 60)) * (30 * 60)) AS timekey from $this->tableName group by timekey";
            } elseif ($unitType=='60') {
                #1h
                $qy="SELECT DATE_FORMAT($this->tableName.time, '%H:00') AS timekey, SUM(work)AS work FROM `$this->tableName` GROUP BY DATE_FORMAT($this->tableName.time, '%H')";
            }
               $result=parent::commitStmt($qy);
               $i=0;
            if ($result) {
                foreach ($result as $row) {
                    $resultArray['work'][$i]=$row['work'];
                    $resultArray['time'][$i]=date("H:i", strtotime($row['timekey']));
                    $i++;
                }
            }
        } catch (Exception $e) {
             parent::setInfoLog($e->getMessage());
        } finally {
             parent::setInfoLog("getSumWorks END");
             return $resultArray;
        }
    }
}
