<?php
class DBConn extends PDO{
    
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

        $pdo=parent::__construct('mysql:dbname=pclog;host=mysqlpclog.cnbqylofmo1r.sa-east-1.rds.amazonaws.com','root','idhpclogtool'); 

      }catch (PDOException $e){
        print('Connection failed:'.$e->getMessage());
        die();
      }
    }
    return $pdo;
    }

    /*
    *クエリ実行関数
    *
    */
    public function query($sql){
        $result = parent::query($sql);
        return $result;
    }
    public function prepare($sql){
        $result = parent::query($sql);
        return $result;
    }
}
?>