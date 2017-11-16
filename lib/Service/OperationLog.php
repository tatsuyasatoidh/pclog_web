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
	const LOGDIR = "/var/Pclogtool/log";
	/** s3上ログファイルパス key*/
	private $logPath_s3KeyPath = "log";
	
	private $logFileName;
	private $logPath_local;
	private $logFullPath_local;
	
	const LOGPATH_LOCAL_15 = "/15Unit";
	const LOGPATH_LOCAL_30 = "/30Unit";
	const LOGPATH_LOCAL_60 = "/60Unit";

	/** インスタンス*/
	private $downLoad;
	
	private $userId;
	private $userName;
	private $companyId;
	private $searchDate;
	
	/**
	 * コンストラクタ
	 * @access public 
	 **/
	public function __construct($userId=NULL,$searchDate = NULL)
	{
		/** インスタンス*/
		$this->downLoad = new DownLoad();
		$this->userEntity = new User($userId);
		/** クラス変数を設定*/	
		$this->userName = $this->userEntity->getUserName();
		$this->companyId = $this->userEntity->getCompanyId();
		$this->userId = $userId;
		$this->searchDate = date('Ymd', strtotime($searchDate));
		/** ログ名を生成*/
		$this->logFileName = "log_".$this->searchDate.".csv";
		$this->logPath_local = "$this->companyId/$this->userId/$this->logFileName";
		$this->logFullPath_local = self::LOGDIR."/$this->logPath_local";
		$this->logPath_s3KeyPath = $this->logPath_s3KeyPath."/$this->logPath_local";
	}
	
	public function getLocalLogPath($type = null)
	{
		switch ($type)
		{
			case '15':
				$dirType = self::LOGPATH_LOCAL_15;
			break;
			case '30':
				$dirType = self::LOGPATH_LOCAL_30;
			break;
			case '60':
				$dirType = self::LOGPATH_LOCAL_60;
			break;
			default:
				$dirType = "";
				break;
		}
		return self::LOGDIR."$dirType/$this->logPath_local";
	}
		
	public function getS3LogPath($type = null)
	{
		return $this->logPath_s3KeyPath;
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
	 * @param string ファイルの出力場所 
	 * @param string s3のkey
	 * @return string ログパス
	 **/
	public function getLogFromS3($outputPath,$key)
	{
		try{
				parent::setInfoLog("getLogFromS3 START");
				parent::setInfoLog("s3 key is $key");
				$this->logFullPath_local = $this->downLoad->getFromS3($this->logFullPath_local,$key);
				parent::setInfoLog("get file is $this->logFullPath_local");
					/** ファイルの取り出しに失敗した場合、エラーを投げる*/
				if(!file_exists($this->logFullPath_local)){
					throw new \exception($this->logFullPath_local."ログファイルの取得に失敗しました。");
				}
		}catch(\Exception $e){
			parent::setInfoLog($e->getMessage());
		}finally{
			parent::setInfoLog("getLogFromS3 END");
		return $this->logFullPath_local;
		}
		
	}
	
	 /*
	 * csvファイルを配列にする
	 * @return  array 配列
	 */
	public function csvToArray($csvFile){
		try{
				parent::setInfoLog("csvToArray START");
				var_dump($csvFile);
				if(!file_exists($csvFile)){
					throw new \Exception("$csvFile is not exist;");
				}
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
	 * グラフ作成用のファイルのgetter
	 * @param string $type グラフのタイプ
	 */
	public function getLog($type)
	{
		$sumamry = $this->getSummary($type);
		exit;
		
	}
	
	/**
	 * Mysqlから指定の時間のサマリを取得しファイルに保管する
	 **/
	 public function getSummary($type) 
	 {
		 $smmary = $this->tmpLogDao->getSumWorks($this->userName, $this->searchDate, $type);
		 return $smmary;
	 }
	
	public function sumarryToCsvFile($array,$csvFile){
		if(!file_exists($csvFile)){
			if(!file_exists(dirname($csvFile))){
				mkdir(dirname($csvFile), 0777, true);
			}
		}
			if(!file_exists($csvFile)){
				touch($csvFile);
			}
		$csvArray =[];
		for ($i = 0; $i < count($array["time"]); $i++)
		{
			$csvArray[$i]["time"] =$array["time"][$i];
			$csvArray[$i]["work"] =$array["work"][$i];
		}
		// ファイルを書き込み用に開きます。
		$file = fopen($csvFile, "w");
		if ( $file ) {
			// $ary から順番に配列を呼び出して書き込みます。
			foreach($csvArray as $line){
				// fputcsv関数でファイルに書き込みます。
				fputcsv($file, $line);
			} 
		}
		// ファイルを閉じます。
		fclose($file);
		return $csvFile;
	}
	
}