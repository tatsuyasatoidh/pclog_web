<?php
class DBConn{
    private $pdo;
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "pclog";
    
    public function __construct() {
        
        // Develop（localhost）
        if (@$_SERVER["SERVER_NAME"] === 'localhost') {
          $dsn = "mysql:dbname=$this->dbname;host=$this->hostname";
          $user = "$this->username";
          $password = "$this->password";

          try{
            $pdo = parent::__construct($dsn, $user, $password);
          }catch (PDOException $e){
            print('Connection failed:'.$e->getMessage());
            die();
          }
            
        }else{

          try{

           /* $pdo=PDO::__construct('mysql:dbname=pclog;host=mysqlpclog.cnbqylofmo1r.sa-east-1.rds.amazonaws.com','root','idhpclogtool'); 
            $dbhost = $_SERVER['RDS_HOSTNAME'];
          */
            $dbs = "mysql:host=pclog.c5q2rhfkfpib.us-west-2.rds.amazonaws.com;dbname=pclog;charset=utf8";
            $user = "root";
            $pass = "idhpclogtool";
           // $sql = "INSERT INTO [テーブル名] (columnNum,  columnStr) VALUES(10, 'テスト');";
            // PDOを使ってRDSに接続
            $this->pdo = new PDO($dbs, $user, $pass);
              
          }catch (PDOException $e){
            print('Connection failed:'.$e->getMessage());
            die();
          }
        }
    return $this->pdo;
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