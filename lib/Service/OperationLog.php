<?php
namespace lib\Service;

class_exists("lib\Service\HttpRequest\Download") or require_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Service/HttpRequest/Download.php';
class_exists("lib\Service\Conf\Configuration") or require_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Service/Conf/Configuration.php';
class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';
class_exists('lib\Dao\TmpLogDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/TmpLogDao.php';
class_exists('lib\Entity\User') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Entity/User.php';

use lib\Service\HttpRequest\Download as DownLoad;
use lib\Service\Conf\Configuration as Configuration;
use lib\Controller\ParentController as ParentController;
use lib\Dao\TmpLogDao as TmpLogDao;
use lib\Entity\User as User;

/**
 * 操作ログを扱うクラス
 * @access public
 */
class OperationLog extends ParentController{
	
	private $operationLogArray = [];
	private $logPath_local = "/var/Pclogtool/log";
	/** s3上ログファイルパス key*/
	private $logPath_s3KeyPath = "log/"; 
	
	/** インスタンス*/
	private $downLoad;
	private $tmpLogDao;
	
	private $userId;
	private $userName;
	private $searchDate;
	
	/**
	 * コンストラクタ
	 * @access public 
	 **/
	public function __construct($userId=NULL,$searchDate = NULL)
	{
		$this->userEntity = new User($userId);
		$this->userName = $this->userEntity->getUserName();
		$this->userId = $userId;
		$this->searchDate = $searchDate;
		/** userIdからNameを取得*/
		
		$this->downLoad = new DownLoad();
		$this->tmpLogDao = new TmpLogDao();
	}
	
	/**
	 * operationLogArrayのgetter
	 * @access public 
	 **/
	public function getOperationLogArray()
	{
		return $this->operationLogArray;
	}
	
	/**
	 * s3から指定のログを取得する関数
	 * @access public 
	 **/
	public function getLogFromS3()
	{
		try{
			parent::setInfoLog("getLogFromS3 START");
			parent::setInfoLog("s3 key is $this->logPath_s3KeyPath");
			if (@$_SERVER["SERVER_NAME"] === 'localhost') {
				/** 開発用*/
				$this->logPath_local = $this->logPath_local."/11/29/log_20171012.csv";
			}else{
				/** keyを使いs3からファイルを取り出す。*/
				$this->logPath_local = $this->downLoad->getFromS3($this->logPath_local,$this->logPath_s3KeyPath);
			}
			/** ファイルの取り出しに失敗した場合、エラーを投げる*/
			if(!file_exists($this->logPath_local)){
				throw new \exception($this->logPath_local."ログファイルの取得に失敗しました。");
			}
		}catch(\Exception $e){
			parent::setInfoLog($e->getMessage());
		}finally{
			parent::setInfoLog("getLogFromS3 END");
		}
		return $this->logPath_local;
	}
	
	/**
	 * 指定の時間ごとにサマリーを作成
	 * @access public 
	 **/
	public function summaryLog($type)
	{
		$logArray = $this->csvToArray($this->logPath_local);
		$this->_dateBy15Minutes($logArray);
		exit;
		switch ($type)
		{
			case 15:
				var_dump("15分");
				break;
			case 30:
			default:
				break;
		}
	}
	
	 /*
	 * csvファイルを配列にする
	 * @return  array 配列
	 */
	public function csvToArray($csvFile){
		try{
				parent::setInfoLog("csvToArray START");
				parent::setInfoLog("csvFile is $csvFile");

				$csvArray  = array();
				$fp   = fopen($csvFile, "r");
				$count =0;
				while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
					$csvArray[$count]["user_name"] = $data[0];
					$csvArray[$count]["date"] = $data[1];
					$csvArray[$count]["time"] = $data[2];
					$csvArray[$count]["key"] = $data[3];
					$csvArray[$count]["work"] = $data[4];
					$count++;
				}
				fclose($fp);
		}catch(\Exception $e){
			parent::setInfoLog($e->getMessage());
			$csvArray = null;
		}finally{
			parent::setInfoLog("csvToArray END");
			return $csvArray;
		}
	}
	
	/**
	 * ログの配列をMysqlに保持
	 **/
	public function InsertLogIntoMysql($csvFile)
	{
		$logArray = $this->csvToArray($csvFile);
		/** mysqlにすでにあるログを削除*/
		$this->tmpLogDao->delete($this->userName, $this->searchDate);
		/** Mysqlにログを入れる*/
		$this->tmpLogDao->InsertLog($logArray);
	}
	
	/**
	 * Mysqlから指定の時間のサマリを取得しファイルに保管する
	 **/
	 public function getSummary($type) {
		 $smmary = $this->tmpLogDao->getSumWorks($this->userName, $this->searchDate, $type);
		 return $smmary;
	 }
	
}