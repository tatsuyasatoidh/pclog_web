<?php
namespace lib\Dao;

class_exists('lib\Dao\ParentDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/ParentDao.php';
include_once dirname(__FILE__).'/../Entity/TmpLog.php';

class TmpLogDao extends ParentDao {

    private $logPath = "log";    
    
    /*
    * tmplogを削除
    * ファイルからデータを取得する前に一度初期化してデータのずれを防ぐ
    */
    public function delete($user_name, $date) {
       try {
            $qy = " DELETE FROM pclog.tmp_log ";
            $qy .=" WHERE user_name='$user_name' AND date='$date'";
		    		parent::setInfoLog($qy);
            $result=parent::commitStmt($qy);
        } catch ( Exception $e ) {
           parent::setInfoLog($e->getMessage());
        } finally {
				 	 return $result;
        }
    }
    
    /*
    * csvファイルからデータをmysqlテーブルにデータを格納する
    */
	public function loadData($csvFile){
		try{
				$qy="LOAD DATA LOCAL INFILE '$csvFile' INTO TABLE tmp_log FIELDS TERMINATED BY ','";
				$result=parent::commitStmt($qy);
		}catch(Exception $e){
				parent::setInfoLog(" FAiled to loadData".$e->getMessage());
		} finally {
			return $result;
		}
	}  
    
    
   public function getSumWorks($user, $date, $interval){
	   try{
				parent::setInfoLog("getSumWorks START");
				$result ="";
				$resultArray="";
				if($interval=='15m'){
				#15分
				$qy="SELECT SUM(work) AS work ,FROM_UNIXTIME(round(UNIX_TIMESTAMP(tmp_log.time) div (15 * 60)) * (15 * 60) , '%H:%i') AS time FROM tmp_log";
				$qy .= " WHERE user_name= '$user' AND date ='$date' GROUP BY time";

				}elseif($interval=='30m'){

				#30分
				$qy="SELECT SUM(work)AS work,FROM_UNIXTIME(round(UNIX_TIMESTAMP(tmp_log.time) div (30 * 60)) * (30 * 60) , '%H:%i') AS time FROM tmp_log";
				$qy .= " WHERE user_name= '$user' AND date ='$date' GROUP BY time";    

				}elseif($interval=='1h'){  
				#1h
				$qy="SELECT DATE_FORMAT(tmp_log.time, '%H:00') AS time, SUM(work)AS work FROM tmp_log";
				$qy .= " WHERE user_name= '$user' AND date ='$date' GROUP BY DATE_FORMAT(tmp_log.time, '%H')";
				}
				$result=parent::commitStmt($qy);
				$i=0;

				if($result){
					foreach($result as $row){
					$resultArray['work'][$i]=$row['work'];
					$resultArray['time'][$i]=$row['time'];
					$i++;
					}
				}else{
					$resultArray="";
				}
		 } catch ( Exception $e ) {
				parent::setInfoLog($e->getMessage());
				die ( $e );
        } finally {
			 parent::setInfoLog("getSumWorks END");
			return $resultArray;
		}
   }
}