<?php

class CreateGraph{
	
	function __construct() {

		require "lib/mysql/TmpLogModel.php" ; 
		require "lib/CommonData.php" ; 
		require "lib/DebugInfo/DebugInfo.php"; 

	}
    
	function dailyGraph($val){
		$TmpLogModel = new TmpLogModel();
		$dataPoints = [];
		$rowcount=0;
		$h=0;#時間
		$i=0;#要素
		$rowarray=[];
		#時間ごとの作業量０の配列を作成。
		$tmplateVal=$this->tmplateVal($val['interval']);

		#一時テーブルから検索日とユーザー名の組み合わせのものを削除。
		$TmpLogModel->delete($val);
		#一時テーブルから検索日とユーザー名の組み合わせのものを格納。
		$result=$TmpLogModel->loadDataIntoTable($val);
		
		if($result){
			$seachVal=$TmpLogModel->selsectGroupByTime($val);
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
	
	function tmplateVal($interval){
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
		return $timedata;
	}
	
	function createGraphTitle($date){
		$title=date('Y年m月d日の時間帯別作業量',strtotime($date));
		return $title;
	}
	
	function createGraphTitleMon($Month){
		$title=date('Y年m月の時間帯別作業量',strtotime($Month));
		return $title;
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
	function monthGraph($val){
		if($val['month']){
			$val['start_date']=$val['month']."-01";
			$val['end_date']=$val['month']."-31";
		}else{
			$val['start_date']="";
			$val['end_date']="";
		}
		$ConnectMysql = new ConnectMysql();
		$result=$ConnectMysql->selectPclogJoinUserJoinCompany($val);	
		if($result){	
			$dataPoints = [];
			$i=0;
			
			#月の日数を取得
			for($i=0;$i<=date('t',strtotime($val['month']));$i++){
				$dataPoints[$i]['y']=0;
				$dataPoints[$i]['name']="";
			}
			foreach($result as $row){
				$i=date('j',strtotime($row['date']));
				$dataPoints[$i]['y']=$row['number_of_work'];
			}		
					
			#グラフのタイトル作成
			$dataPoints['title']=$this->createGraphTitleMon($val['month']);	
		}else{
			$dataPoints=false;
		}
		
		return $dataPoints;
	}
	
	function Every15MinutesData(){
		$data=[];
		$h='00';
		$m='00';
			for($i=0,$k=1;$i<96;$i++,$k++){
				#桁調整
				if($m==0){
					$m='00';
				}
				#時間
				$time=$h.':'.$m;
				#配列の要素にする
				$data['work'][$i]=0;
				$data['time'][$i]=$time;
				$data['color'][$i]="#ccc";

				switch($k){
					case 1:
						$m=15;
						break;
					case 2:
						$m=30;
						break;
					case 3:
						$m=45;
						break;
					case 4:	
						$h= $h+1;
						$m=0;
						$k=0;
						#桁調整
						if($h<10){
							$h='0'.$h;
						}
						break;
				}
			}
			return $data;
	}
	
	function Every30MinutesData(){
		$data=[];
		$h='00';
		$m='00';
			for($i=0,$k=1;$i<48;$i++,$k++){
				#桁調整
				if($m==0){
					$m='00';
				}
				#時間
				$time=$h.':'.$m;
				#配列の要素にする
				$data['work'][$i]=0;
				$data['time'][$i]=$time;
				$data['color'][$i]="#ccc";

				switch($k){
					case 1:
						$m=30;
						break;
					case 2:	
						$h= $h+1;
						$m=0;
						$k=0;
						#桁調整
						if($h<10){
							$h='0'.$h;
						}
						break;
				}
			}
			return $data;
	}
	#１ｈのグラフデータ
	function EveryHoursData(){
		$data=[];
		$h='00';
		$m='00';
			for($i=0;$i<24;$i++){
				#桁調整
				if($m==0){
					$m='00';
				}
				#時間
				$time=$h.':'.$m;
				#配列の要素にする
				$data['work'][$i]=0;
				$data['time'][$i]=$time;
				$data['color'][$i]="#ccc";

				$h= $h+1;
				$m=0;
				$k=0;
				#桁調整
				if($h<10){
					$h='0'.$h;
				}
			}
			return $data;
	}

	}
