<?php

include_once "../mysql/TmpLogDao.php" ; 
include_once "../CommonData.php" ; 
 
include_once dirname(__FILE__)."/CreateGraph.php";

class Create30minGraph extends CreateGraph{
	
	function create($val){
      
		$TmpLogDao = new TmpLogDao();
		$dataPoints = [];
		$rowcount=0;
		$h=0;#時間
		$i=0;#要素
		$rowarray=[];
      
		#時間ごとの作業量０の配列を作成。
		$tmplateVal=$this->tmplateVal($val['interval']);

		#一時テーブルから検索日とユーザー名の組み合わせのものを削除。
		$TmpLogDao->delete($val);
		#一時テーブルから検索日とユーザー名の組み合わせのものを格納。
		$result=$TmpLogDao->loadDataIntoTable($val);
		
		if($result){
			$seachVal=$TmpLogDao->selsectGroupByTime($val);
			if($seachVal){
					#検索した日の作業量と比較し配列を作成
					$dataPoints=$this->compareMysqlLog($tmplateVal,$seachVal);
			}else{
				$dataPoints=false;
			}
		}else{
			$dataPoints=false;
		}
		
		#グラフのタイトル作成
		$dataPoints['title']=$this->createGraphTitle($val['date']);	
		return $dataPoints;
	}
	
	function createGraphTitle($date){
		$title=date('Y年m月d日の時間帯別作業量',strtotime($date));
		return $title;
	}
	
	function createGraphTitleMon($Month){
		$title=date('Y年m月の時間帯別作業量',strtotime($Month));
		return $title;
	}

}
