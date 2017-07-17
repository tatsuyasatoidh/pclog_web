<?php
include_once dirname(__FILE__).'/../Common/AbstractDao.php';
include_once dirname(__FILE__).'/../Entity/TmpLog.php';

class TmpLogDao extends AbstractDao {

    private $logPath = "log";    
    
    /*
    * tmplogを削除
    * ファイルからデータを取得する前に一度初期化してデータのずれを防ぐ
    */
    public function delete($user_name, $date) {
       try {
            $qy = " DELETE FROM pclog.tmp_log ";
            $qy .=" WHERE user_name='$user_name' AND date='$date'";
            $result=parent::commitStmt($qy);
            return $result;
        } catch ( Exception $e ) {
           echo $e;
           die ( $e );
        } finally {
        }
    }
    
    /*
    * csvファイルからデータをmysqlテーブルにデータを格納する
    */
    function loadData($array){
         for($i=0;$i<count($array);$i++)
        {
            $userName =(($array[$i][0]));
            $date =(($array[$i][1]));
            $time =(($array[$i][2]));
            $work =1;
        
            $qy=
                'INSERT INTO pclog.tmp_log(
                    `user_name`,
                    `date`,
                    `time`,
                    `work`
                )VALUES (
                    "'.$userName.'", 
                    "'.$date.'", 
                    "'.$time.'",
                    "'.$work.'"
                )';
            $result=parent::commitStmt($qy);
        }
        return $result;
	   }  
    
    
   public function getSumWorks($user, $date, $interval){
       
		$result ="";
       
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
        return false;
    }
    
		return $resultArray;
	}
}