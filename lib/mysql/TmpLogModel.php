<?php
include_once dirname(__FILE__)."/ConnectMysql.php";
class TmpLogDao extends ConnectMysql
{
    
    function __construct()
    {
    }
    function delete($param)
    {
        $ConnectMysql= new ConnectMysql();
        $user_name=$param['user_name'];
        $date=$param['date'];
        
        $sql="DELETE FROM pclog.tmp_log WHERE user_name='".$user_name."'AND date='".$date."'";
        $result=$ConnectMysql->query($sql);
        return $result;
    }
    
    function loadDataIntoTable($param)
    {
        $ConnectMysql= new ConnectMysql();
        $user_name=$param['user_name'];
        $date=$param['date'];
    
        #LOADDATA
        $filepath= "C:/xampp/htdocs/pclog/lib/Log/".$user_name."/".$date."/log.csv";
        $sql="LOAD DATA INFILE '$filepath' INTO TABLE tmp_log FIELDS TERMINATED BY ','";
        $result =$ConnectMysql->query($sql);
        
        return $result;
    }
    
    function selsectGroupByTime($param)
    {
        $ConnectMysql= new ConnectMysql();
        $result ="";
        
        if ($param['interval']=='15m') {
            #15分
            $sql="SELECT SUM(work) AS work ,FROM_UNIXTIME(round(UNIX_TIMESTAMP(tmp_log.time) div (15 * 60)) * (15 * 60) , '%H:%i') AS time FROM tmp_log GROUP BY time";
        } elseif ($param['interval']=='30m') {
            #30分
            $sql="SELECT SUM(work)AS work,FROM_UNIXTIME(round(UNIX_TIMESTAMP(tmp_log.time) div (30 * 60)) * (30 * 60) , '%H:%i') AS time FROM tmp_log GROUP BY time";
        } elseif ($param['interval']=='1h') {
            #1h
            $sql="SELECT DATE_FORMAT(tmp_log.time, '%H:00:00') AS time, SUM(work)AS work FROM tmp_log GROUP BY DATE_FORMAT(tmp_log.time, '%H')";
        }
        $result= $ConnectMysql->query($sql);
        $i=0;
        foreach ($result as $row) {
            $resultArray['work'][$i]=$row['work'];
            $resultArray['time'][$i]=$row['time'];
            $i++;
        }
        return $resultArray;
    }
};
