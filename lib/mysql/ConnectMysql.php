<?php
class ConnectMysql extends PDO
{
    
    function __construct()
    {
        // Develop（localhost）
        if (@$_SERVER["SERVER_NAME"] === 'localhost') {
            $dsn = 'mysql:dbname=pclog;host=localhost';
            $user = 'root';
            $password = '';
            try {
                $pdo = parent::__construct($dsn, $user, $password);
            } catch (PDOException $e) {
                print('Connection failed:'.$e->getMessage());
                die();
            }
        } else {
            try {
                $pdo=parent::__construct('mysql:dbname=pclog;host=mysqlpclog.cnbqylofmo1r.sa-east-1.rds.amazonaws.com', 'root', 'idhpclogtool');
            } catch (PDOException $e) {
                print('Connection failed:'.$e->getMessage());
                die();
            }
        }
        return $pdo;
    }

    function query($sql)
    {
        $result = parent::query($sql);
        return $result;
    }
}
