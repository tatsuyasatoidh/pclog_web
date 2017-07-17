<?php
include_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Common/autoloader.php';
include_once dirname(__FILE__).'/../Log4j/Logger.php';

abstract class AbstractDao {
    // http://php.net/manual/kr/mysqli-stmt.bind-param.php
    // http://php.net/manual/en/mysqli.prepare.php
    // http://php.net/manual/en/pdostatement.execute.php
    private $db;
    private $mysqli;
    private $logger;

    public function AbstractDao(){
        Logger::configure ( dirname(__FILE__).'/../Log4j/config.xml' );
        $this->logger = Logger::getLogger ( get_class ( $this ) );
    }

    protected function getStmt($qy) {
        $this->db = new DBConn ();
        $stmt = $this->db->stmtPrepare ( $qy );
        return $stmt;
    }
    protected function commitStmt($qy) {
        $this->db = new DBConn ();
        return $this->db->query($qy);
    }

    protected function close() {
        $this->mysqli->close ();
    }

    protected function setDebug($message) {
        $this->logger->debug ( $message );
    }

    protected function setInfoLog($message) {
        //$this->logger->info ( $message );
        $dbug = debug_backtrace();
       // var_dump("<pre>"."file :".$dbug[0]['file']." line :".$dbug[0]['line']." "." function :".$dbug[1]['function']." <br>".$message."</pre>");
    }

    protected function setErrorLog($message) {
        $this->logger->error ( $message );
    }

}
?>