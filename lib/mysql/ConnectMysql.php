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
    
	function query($sql){
		$result = parent::query($sql);
		return $result;
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
	
	
}

?>