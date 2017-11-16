<?php
namespace lib\Service;

class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';
class_exists('lib\Dao\PclogDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/PclogDao.php';
class_exists('lib\Dao\TmpLogDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/TmpLogDao.php';
class_exists("lib\Service\TemplateValue") or require_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Service/TemplateValue.php';
class_exists("lib\Service\HttpRequest\Download") or require_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Service/HttpRequest/Download.php';
class_exists("lib\Service\FileManage") or require_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Service/FileManage.php';
class_exists('lib\Service\OperationLog') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Service/OperationLog.php';

use lib\Controller\ParentController as ParentController;
use lib\Service\TemplateValue as TemplateValue;
use lib\Dao\PclogDao as PclogDao;
use lib\Dao\TmpLogDao as TmpLogDao;
use lib\Service\HttpRequest\Download as DownLoad;
use lib\Service\FileManage as FileManage;
use lib\Service\OperationLog as OperationLog;

class Graph extends ParentController{
		
	const LOGDIR = "/var/PclogTool/log";
	private $Ymd;
	private $user;
	private $company;
	private $interval;
	private $result;
	
	private $GraphINfoPath_15 =[];
	private $GraphINfoPath_30 =[];
	private $GraphINfoPath_60 =[];
	
	/** エラーメッセージ*/
	private $errorMessage = [];
	
	const GRAPH_TYPE_15 = "15";
	const GRAPH_TYPE_60 = "60";
    
//		/**
//		 * クラス変数に値をセットする関数
//		 * @access public
//		 * @param array $param 入力値
//		 **/
//    private function setVal($post){
//			parent::setInfoLog("setVal START"); 
//			$this->Ymd      = date('Ymd',strtotime($post["date"]));
//			/**企業名での検索はIDHのみ*/
//			//$this->company  = $post["company"];
//			$this->user     = $post["user"];
//			/** s3　keyを生成*/
//			$this->s3KeyPath .= $this->company. "/" .$this->user. "/" .$this->Ymd;
//			parent::setInfoLog("setVal END"); 
//    }
    
		/**
		 * グラフ作成実行関数
		 * @access public
		 * @param array $param 入力値
		 **/
    public function create($userId,$date)
    {
			try{
				parent::setInfoLog("create START");
				$result = false;
				/**　操作ログを扱うクラス */
				$this->operationLog = new OperationLog($userId,$date);
//				/** 操作ログファイル（グラフ用）のファイルがあるかを確認*/
//				if(file_exists($GraphINfoPath)){
//					/** グラフ作成用のファイルがすでに作成されている場合はそのファイルを使用してグラフを作成する*/
//					parent::setInfoLog("file exist $GraphINfoPath");
//					$this->GraphINfoPathArray = $this->getInfoFromCsv($GraphINfoPath);
//				}else{
					$this->tmpLogDao = new TmpLogDao($userId,$date);
					/** グラフがない場合はS3からログを取得*/
					$logs3Key = $this->operationLog->getS3LogPath();
					/** 操作ログファイルを出力するパスを生成*/
					$outputPath = $this->operationLog->getLocalLogPath();
					/** ログファイルをS3から取得*/
					$logPath = $this->operationLog->getLogFromS3($outputPath,$logs3Key);
					if(!file_exists($logPath)){
						throw new \exception("s3からログを取得処理に失敗しました");
					}
					/** ログファイルをmysqlに追加して操作*/
					$this->tmpLogDao->createTable();
					$this->tmpLogDao->loadDataCsv($logPath);
					/** 15分ごとのグラフのサマリーを取得*/
					$this->GraphINfoPath_15 =$this->createGraphInfoArray(self::GRAPH_TYPE_15);
					/** 1hごとのグラフのサマリーを取得*/
					$this->GraphINfoPath_60 =$this->createGraphInfoArray(self::GRAPH_TYPE_60);
//				}
				$result = true;
			}catch(\exception $e){
				parent::setInfoLog($e->getMessage());
				
			}finally{
				parent::setInfoLog("create END");
				return $result;
			}
    }
	
	/*
	 * 24時間グラフを作成する関数
	 * @param string csvファイルのパス
	 * @return  array 配列
	 */
	public function createGraphInfoArray($graphType)
	{
	try{
				parent::setInfoLog("create24Graph START");
				$result = null;
				$TemplateValue = new TemplateValue($graphType);
				/** 操作ログファイル（グラフ用）のパスを生成*/
				$GraphInfoPath = $this->operationLog->getLocalLogPath($graphType);
				$sumaryWorkArray = $this->tmpLogDao->getSumWorks($graphType);
				/** 時間単位別のテンプレートログを取得*/
				$tmpArray = $TemplateValue->getTempLog();
				/** テンプレートログとMYsqlから取り出したサマリーを照合*/
				$sumaryWorkArray = $TemplateValue->compareMysqlLog($tmpArray,$sumaryWorkArray);
				$GraphInfoPath = $this->operationLog->sumarryToCsvFile($sumaryWorkArray,$GraphInfoPath);
				/** 作成した配列からCSVファイルを作成*/
				$result = $this->getInfoFromCsv($GraphInfoPath);
			}catch(\exception $e){
				parent::setInfoLog($e->getMessage());
			}finally{
				parent::setInfoLog("create24Graph END");
				return $result;
			}
    }

	
	 /*
	 * csvファイルを配列にする
	 * @param string csvファイルのパス
	 * @return  array 配列
	 */
	public function getInfoFromCsv($csvFile){
		try{
					parent::setInfoLog("getInfoFromCsv START");
					if(!file_exists($csvFile)){
						throw new \Exception("$csvFile is not exist;");
					}
					$csvArray  = array();
					$fp   = fopen($csvFile, "r");
					$count =0;
					while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
						$csvArray["time"][$count] = $data[0];
						$csvArray["work"][$count] = $data[1];
						$count++;
					}
					fclose($fp);
			}catch(\Exception $e){
				parent::setInfoLog($e->getMessage());
				$csvArray = null;
			}finally{
				parent::setInfoLog("getInfoFromCsv END");
				return $csvArray;
			}
	}
	
	/** 
	 * GraphINfoPathArrayのgetter
	 * @access public 
	 */
	public function getGraphINfoPathArray()
	{
		return $this->GraphINfoPathArray;
	}
	
	/** 
	 * 15分用グラフの情報のgetter
	 * @access public 
	 */
	public function getGraphINfoPath_15()
	{
		return $this->GraphINfoPath_15;
	}				
		
	/** 
	 * 60分用グラフの情報のgetter
	 * @access public 
	 */
	public function getGraphINfoPath_60()
	{
		return $this->GraphINfoPath_60;
	}
    public function getResult()
    {
        return $this->result;
    }
    
    /** 結果の合計を取得*/
    public function getTotalWork(){
        $result = $this->GraphINfoPath_15;
        return array_sum($result['work']);
    }
    
    /* */
    private function tmplateVal($interval){
        #全体のグラフのピースを用意
        if($interval=="15m"){
          $timedata=$this->Every15MinutesData();
        }elseif($interval=="30m"){
          $timedata=$this->Every30MinutesData();
        }elseif($interval=="1h"){
          $timedata=$this->EveryHoursData();
        }else{
          $timedata="";
        }
		foreach ($timedata["time"] as $value)
		{
			echo $value.",";
		}
        return $timedata;
    }
	
	#mysql tmp_logと比較
	function compareMysqlLog($tmplateVal,$seachVal){

		for($count=0;$count<count($tmplateVal['time']);$count++){
			
			if(in_array($tmplateVal['time'][$count],$seachVal['time'])){
					$i=0;
					foreach($seachVal['time'] as $sTimeVal){
						if($tmplateVal['time'][$count]==$sTimeVal){
							$dataPoints['work'][$count]=$seachVal['work'][$i];
							$dataPoints['time'][$count]=$seachVal['time'][$i];							
						}
							$i++;	
					}
			}else{
				$dataPoints['work'][$count]=$tmplateVal['work'][$count];
				$dataPoints['time'][$count]=$tmplateVal['time'][$count];
		  }
		}
		return $dataPoints;
  }

    /*抽出結果が0件*/
  protected function dataNotAvailable(){
		parent::setInfoLog("data not available");
		$this->errorMessage["dataNotAvailable"] = "抽出結果が0件です。";
		return false;  
  }
	
	/**
	 * エラーメッセージのgetter
	 */
	public function getErrorMessage(){
		return $this->errorMessage;
	} 
    
	}
