<?php
namespace lib\Dao;

class_exists('lib\Dao\DbConnection') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/DbConnection.php';
class_exists("Sys\Logging") 
    or require_once $_SERVER['DOCUMENT_ROOT']."/lib/Sys/Logging.php";

use Sys\Logging as Logging;
use lib\Dao\DbConnection as DbConnection;

class ParentDao
{
    private $db;
    private $mysqli;
    protected $logging;

    public function __construct()
    {
        $this->logging = new Logging();
        $this->db = new DbConnection();
    }
    
    protected function getStmt($qy)
    {
        $stmt = $this->db->stmtPrepare($qy);
        return $stmt;
    }
    
    protected function commitStmt($qy)
    {
        $this->logging->info("commitStmt START");
        $this->logging->info("sql : $qy");
        $result = $this->db->query($qy);
        $this->logging->info("commitStmt END");
        return $result;
    }
    
    protected function close()
    {
        $this->mysqli->close();
    }

}
