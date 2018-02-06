<?php
namespace lib\Log;

class LogWriter
{
    private $logFile;
    
    public function __construct()
    {
        $this->logFile = "/tmp/pclogTool_".date('Ymd').".log";
    }
    
    /** ログをファイルに書き出す*/
    private function write($log)
    {
        error_log($log."\n", 3, $this->logFile);
        //print_r($log."<br>");
    }

    public function info($message)
    {
        $trace = ($this->backTrace());
        $message = "[INFO] ".$trace."  ".$message;
        $this->write($message);
    }
    
    private function backTrace()
    {
        $dbug = debug_backtrace();
        $dbStr = "[ File:".$dbug[2]['file']." L:".$dbug[2]['line']." "." Fn:".$dbug[3]['function']." ]";
        return $dbStr;
    }
}
