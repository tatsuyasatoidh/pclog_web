<?php
namespace lib\Dao;

use \PDO;

class DbConnection extends PDO
{
    private $pdo;
    
    const LOCAL_HOSTNAME = "localhost";
    const LOCAL_USERNAME = "root";
    const LOCAL_PASSWORD = "";
    const LOCAL_DBNAME = "pclog";
    
    const PRO_HOSTNAME = "pclog.c5q2rhfkfpib.us-west-2.rds.amazonaws.com";
    const PRO_USERNAME = "root";
    const PRO_PASSWORD = "idhpclogtool";
    const PRO_DBNAME = "pclog";
    
    /**
     * コンストラクタ
     *
     * @access public
     * @return pdo
     **/
    public function __construct()
    {
        try {
            if (@$_SERVER["SERVER_NAME"] === 'localhost') {
                //localhostの場合
                $dsn = "mysql:dbname=".self::LOCAL_DBNAME.";host=".self::LOCAL_HOSTNAME;
                $user = self::LOCAL_USERNAME;
                $password = self::LOCAL_PASSWORD;
            } else {
                //PROの場合
                $dsn = "mysql:dbname=".self::PRO_DBNAME.";host=".self::PRO_HOSTNAME;
                $user = self::PRO_USERNAME;
                $password = self::PRO_PASSWORD; 
            }
             $this->pdo = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));
        } catch (\PDOException $e) {
            print('Connection failed:'.$e->getMessage());
        }finally{
            return $this->pdo;
        }
    }

    /*
    *クエリ実行関数
    *
    */
    public function query($sql)
    {
        $result = $this->pdo->query($sql);
        return $result;
    }
    
    public function stmtPrepare($sql)
    {
        $result = $this->pdo->prepare($sql, true);
        return $result;
    }
}
