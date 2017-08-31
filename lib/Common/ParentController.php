<?php
date_default_timezone_set ( "Asia/Tokyo" );
include_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Common/autoloader.php';

class ParentController{
    protected function setDebug($message) {
		$this->logger->debug ( $message );
	}
	protected function setInfoLog($message) {
        $dbug = debug_backtrace();
	}
	protected function setErrorLog($message) {
		$this->logger->error ( $message );
	}
}