<?php
namespace lib\Dao;

class_exists('lib\Dao\DbConnection') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/DbConnection.php';
class_exists('lib\Log\LogWriter') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Log/LogWriter.php';

use lib\Dao\DbConnection as DbConnection;
use lib\Log\LogWriter as LogWriter;

class ParentDao {
    private $db;
    private $mysqli;
    private $logger;

	public function __construct()
	{
			$this->logger = new LogWriter();
	}
    
	protected function getStmt($qy) {
        $this->db = new DbConnection ();
        $stmt = $this->db->stmtPrepare ( $qy );
        return $stmt;
    }
    protected function commitStmt($qy) {
			$this->db = new DbConnection ();
			$this->setInfoLog($qy);
			return $this->db->query($qy);
    }
    protected function close() {
        $this->mysqli->close ();
    }
    protected function setDebug($message) {
				$this->logger = new LogWriter();
        $this->logger->debug ( $message );
    }
    protected function setInfoLog($message) {
				$this->logger = new LogWriter();
				$this->logger->info($message);
    }
    protected function setErrorLog($message) {
				$this->logger = new LogWriter();
        $this->logger->error ( $message );
    }
}
?>