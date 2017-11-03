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
	
	private $GraphINfoPathArray =[];
	
	/** エラーメッセージ*/
	private $errorMessage = [];
    
		/**
		 * クラス変数に値をセットする関数
		 * @access public
		 * @param array $param 入力値
		 **/
    private function setVal($post){
			parent::setInfoLog("setVal START"); 
			$this->Ymd      = date('Ymd',strtotime($post["date"]));
			$this->company  = $post["company"];
			$this->user     = $post["user"];
			$this->interval = $post["type"];
			/** s3　keyを生成*/
			$this->s3KeyPath .= $this->company. "/" .$this->user. "/" .$this->Ymd;
			parent::setInfoLog("setVal END"); 
    }
    
		/**
		 * グラフ作成実行関数
		 * @access public
		 * @param array $param 入力値
		 **/
    public function create($companyId,$user,$date,$type)
    {
			try{
				parent::setInfoLog("create START");
				$result = false;
				$operationLog = new OperationLog();
				$date = date('Ymd', strtotime($date));
				$GraphINfoPath = self::LOGDIR."/".$type."unit/$companyId/$user/log_$date.csv";
				
				if(file_exists($GraphINfoPath)){
					/** グラフ作成用のファイルがすでに作成されている場合はそのファイルを使用してグラフを作成する*/
					parent::setInfoLog("file exist $GraphINfoPath");
					$this->GraphINfoPathArray = $this->getInfoFromCsv($GraphINfoPath);
					$result = true;
				}else{
					parent::setInfoLog("file exist $GraphINfoPath");
					/** グラフがない場合はS3からログ*/
					
					$result = false;
				}			
			}catch(exception $e){
				parent::setInfoLog($e->getMessage()); 
			}finally{
				parent::setInfoLog("create END");
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
		
    public function getResult()
    {
        return $this->result;
    }
    
    /** 結果の合計を取得*/
    public function getTotalWork(){
        $result = $this->result;
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
		
	#$val フォームの値（user_name,）
	function monthGraph($val)
  {
		parent::setInfoLog("monthGraph START"); 
    $PclogDao = new PclogDao();
		if(isset($val['month'])){
			$val['start_date']=$val['month']."-01";
			$val['end_date']=$val['month']."-31";
		}else{
			$val['start_date']="";
			$val['end_date']="";
		}
		$result=$PclogDao->getAllWhere($val['company'], $val['user'], $val['start_date'], $val['end_date'] );
      
		if($result){	
			$dataPoints = [];
			$i=0;
			
			#月の日数を取得
			for($i=0;$i<=date('t',strtotime($val['month']));$i++){
				$dataPoints['work'][$i]=0;
        $dataPoints['date'][$i]=$val['month']."-".$i;
			}
			foreach($result as $row){
				$i=date('j',strtotime($row['date']));
				$dataPoints['work'][$i]=$row['number_of_work'];
			}
		}else{
			$dataPoints=false;
		}
      $this->result =  $dataPoints;
			parent::setInfoLog("monthGraph END"); 
      return true;
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
