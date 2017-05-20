<?php
class ConnectMysql extends PDO{
	
	function __construct() {
		// Develop（localhost）
		if (@$_SERVER["SERVER_NAME"] === 'localhost') {
			$dsn = 'mysql:dbname=pclog;host=localhost';
			$user = 'root';
			$password = '';

			try{
				$pdo = parent::__construct($dsn, $user, $password);
			}catch (PDOException $e){
				print('Connection failed:'.$e->getMessage());
				die();
			}
		}
		return $pdo;
	}
	
	function selectPclogJoinUserJoinCompany($param){
		$sql="SELECT pclog.id,pclog.date,pclog.user_id,pclog.number_of_work,user.user_name,company.company_name
						FROM pclog 
						JOIN user ON pclog.user_id = user.id 
						JOIN company ON user.company_id = company.id";
		if($param){
			$sql=$sql." "."WHERE 1=1";
		}
		if($param['company']){
			$sql=$sql." AND "."company.company_name ='".$param['company']."'";
		}
		if($param['user']){
			$sql=$sql." AND "."user.user_name ='".$param['user']."'";
		}
		if($param['start_date']){
			$sql=$sql." AND "."pclog.date >='".$param['start_date']."'";
		}
		if($param['end_date']){
			$sql=$sql." AND "."pclog.date <='".$param['end_date']."'";
		}

		$result = parent::query($sql);

		return $result;
	}
	
	
	function loadDataIntoTmplogTable($param){
		
		$user_name=$param['user_name'];
		$date=$param['date'];
		
		$sql="DELETE FROM pclog.tmp_log WHERE 1=1";
		parent::query($sql);
		
		#LOADDATA
		$filepath= "C:/xampp/htdocs/pclog/lib/Log/".$user_name."/".$date."/log.csv";
		$sql="LOAD DATA INFILE '$filepath' INTO TABLE tmp_log FIELDS TERMINATED BY ','";
		parent::query($sql);
	
		$result ="";
		if($param['interval']=='15m'){
			#15分
			$sql="SELECT SUM(work) AS work ,FROM_UNIXTIME(round(UNIX_TIMESTAMP(tmp_log.time) div (15 * 60)) * (15 * 60) , '%H:%i') AS time FROM tmp_log GROUP BY time";

		}elseif($param['interval']=='30m'){
			#30分
			$sql="SELECT SUM(work)AS work,FROM_UNIXTIME(round(UNIX_TIMESTAMP(tmp_log.time) div (30 * 60)) * (30 * 60) , '%H:%i') AS time FROM tmp_log GROUP BY time";
		}elseif($param['interval']=='1h'){
			#1h
			$sql="SELECT DATE_FORMAT(tmp_log.time, '%H:00:00') AS time, SUM(work)AS work FROM tmp_log GROUP BY DATE_FORMAT(tmp_log.time, '%H')";
		}
		$result = parent::query($sql);

		return $result;
	}
};

?>