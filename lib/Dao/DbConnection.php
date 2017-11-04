<?php
namespace lib\Dao;

use \PDO;

class DbConnection extends PDO{
    private $pdo;
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "pclog";
   
	/**
	 * コンストラクタ
	 * @access public
	 * @return pdo
	 **/
	public function __construct() {
		try{
			if (@$_SERVER["SERVER_NAME"] === 'localhost') {
				$dsn = "mysql:dbname=$this->dbname;host=$this->hostname";
				$user = "$this->username";
				$password = "$this->password";
				$this->pdo =  new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));
			}else{
				$dbs = "mysql:host=pclog.c5q2rhfkfpib.us-west-2.rds.amazonaws.com;dbname=pclog;charset=utf8";
				$user = "root";
				$pass = "idhpclogtool";
				// $sql = "INSERT INTO [テーブル名] (columnNum,  columnStr) VALUES(10, 'テスト');";
				// PDOを使ってRDSに接続
				$this->pdo = new PDO($dbs, $user, $pass,array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));
			}
		}catch (PDOException $e){
			print('Connection failed:'.$e->getMessage());
			die();
		}finally{
			return $this->pdo;
		}
	}

    /*
    *クエリ実行関数
    *
    */
    public function query($sql){
        $result = $this->pdo->query($sql);
        return $result;
    }
    
    public function stmtPrepare($sql){
        $result = $this->pdo->prepare($sql,true);
        return $result;
    }
}
?>