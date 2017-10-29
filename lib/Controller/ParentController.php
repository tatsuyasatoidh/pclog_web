<?php
namespace lib\Controller;

date_default_timezone_set ( "Asia/Tokyo" );

class_exists('lib\Log\LogWriter') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Log/LogWriter.php';

use lib\Log\LogWriter as LogWriter;
class ParentController
{	
	private $logger;

	public function __construct()
	{
		$this->logger = new LogWriter();
	}

	protected function setDebug($message) {
		$this->logger->debug ( $message );
	}
	public function setInfoLog($message) {
		$this->logger = new LogWriter();
		$this->logger->info($message);
	}
	protected function setErrorLog($message) {
		$this->logger->error ( $message );
	}
	
	/** 
	 *文字列に文字列を追加する。その際に重複がある場合は削除する
	 *@access private
	 *@param string $str 元の文字列
	 */
	protected function appendStr($str,$appendStr)
	{
		$str .="$appendStr"; 
		$str = str_replace($appendStr.$appendStr,$appendStr,$str);
		return $str;
	}

}