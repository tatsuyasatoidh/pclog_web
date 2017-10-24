<?php
namespace lib\Service;

class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';
class_exists('lib\Dao\PclogDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/PclogDao.php';
class_exists('lib\Dao\TmpLogDao') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Dao/TmpLogDao.php';
class_exists("lib\Service\TemplateValue") or require_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Service/TemplateValue.php';
class_exists("lib\Service\HttpRequest\Download") or require_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Service/HttpRequest/Download.php';
class_exists("lib\Service\FileManage") or require_once $_SERVER ['DOCUMENT_ROOT'].'/lib/Service/FileManage.php';

use lib\Controller\ParentController as ParentController;
use lib\Service\TemplateValue as TemplateValue;
use lib\Dao\PclogDao as PclogDao;
use lib\Dao\TmpLogDao as TmpLogDao;
use lib\Service\HttpRequest\Download as DownLoad;
use lib\Service\FileManage as FileManage;

class CreateGraph extends ParentController{
	
	private $Ymd;
	private $user;
	private $company;
	private $interval;
	private $result;
	/** s3上ログファイルパス key*/
	private $s3KeyPath = "log/"; 
	
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
    public function create($post)
    {
			try{

				parent::setInfoLog("create START"); 
				/** ファイルマネージクラスのインスタンス*/
				$fileManage = new FileManage();
				/** 一時テーブルDaoインスタンス*/
				$TmpLogDao = new TmpLogDao();
				
				/** 入力値を暮らす変数にセット*/
				$this->setVal($post);
				
				if (@$_SERVER["SERVER_NAME"] === 'localhost') {
					/** 開発用*/
					$csvFile ="/tmp/PcLogTool/log/11/29/log_20171012.csv";
				}else{
					/** s3からファイルの読み込み*/
					$csvFile = $this->getLog($this->company,$this->user,$this->Ymd);
				}
				/** ファイルの取り出しに失敗した場合、エラーを投げる*/
				if(!$csvFile){
					throw new exception("ログファイルの取得に失敗しました。");
				}
			  /** csvから配列を作成*/
				$csvArray = $fileManage->csvToArray($csvFile);
			  /** 一時テーブルから検索日とユーザー名の組み合わせのものを削除。*/
        $TmpLogDao->delete($this->user, $this->Ymd);
				/** 配列の内容を一時テーブルに配列を保存。*/
				$result=$TmpLogDao->loadData($csvFile);
				if($result){
					$seachVal=$TmpLogDao->getSumWorks($this->user, $this->Ymd, $this->interval);
					if($seachVal){
						#検索した日の作業量と比較し配列を作成
						$dataPoints=$this->compareMysqlLog($tmplateVal,$seachVal);
					}else{
						$dataPoints=false;
					}
				}else{
					$dataPoints=false;
				}
//			$TemplateValueArray = new TemplateValue($this->interval);
//			$fileManage = new FileManage();
//			$dataPoints = [];
//        \:olk
//        #一時テーブルから検索日とユーザー名の組み合わせのものを削除。
//        $TmpLogDao->delete($this->user, $this->Ymd);
//		/** s3からファイルの読み込み*/
//		//$csvFile = $this->getLog($this->company,$this->user,$this->Ymd);
//		$csvFile =dirname(__FILE__)."/log.csv";
//        /** csvから配列を作成*/
//		$csvArray = $fileManage->csvToArray($csvFile);
//
//		#配列の内容を一時テーブルに配列を保存。
//		$result=$TmpLogDao->loadData($csvArray);
//

//		$this->result = $dataPoints;
//		parent::setInfoLog("create END"); 
//		return $dataPoints;
				
				
			}catch(exception $e){
				parent::setInfoLog($e->getMessage()); 
			}finally{
				parent::setInfoLog("create END");
			}
			
    }
	
	private function getLog($company,$user,$Ymd)
	{
		try{
			parent::setInfoLog("getLog START");
			$downLoad = new DownLoad();
			parent::setInfoLog("s3 key is $this->s3KeyPath");
			/** keyを使いs3からファイルを取り出す。*/
			$csvFile = $downLoad->getFromS3($this->s3KeyPath);
		}catch(Exception $e){
			
		}finally{
			parent::setInfoLog("getLog END");
		}
	
		return $csvFile;
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
    
    /* 15分グラフ */
    public function fifteenthMin($val)
    {
        var_dump($val);
        $this->setVal($val['date'], $val['company'], $val['user'],"15m");
        $result = $this->create();
        if(!$result){
            return $this->dataNotAvailable();
        }else{
            return $result;
        }
    }
    
    /** 30分グラフ */
    public function thirtiethMin($val)
    {
        $this->setVal($val['date'], $val['company'], $val['user'],"30m");
        $result = $this->create();
        if(!$result){
            return $this->dataNotAvailable();
        }else{
            return $result;
        }
    }
    
    /** 1時間グラフ */
    public function hourhMin($val)
    {
        $this->setVal($val['date'], $val['company'], $val['user'],"1h");
        $result = $this->create();
        if(!$result){
            return $this->dataNotAvailable();
        }else{
            return $result;
        }
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
