<?php

class CreateGraph{
	
	function __construct() {
		require("lib/mysql/ConnectMysql.php"); 
		require("lib/CommonData.php"); 
		require("lib/DebugInfo/DebugInfo.php"); 
	}
	function dailyGraph($val){
		$ConnectMysql = new ConnectMysql();
		$result=$ConnectMysql->loadDataIntoTmplogTable($val);
		$dataPoints = [];
		$rowcount=0;
		$h=0;#時間
		$i=0;#要素
		$rowarray=[];
		#作業量がmysqlに入っているならtrue
		if($result){
			foreach($result as $row){
				$rowarray['time'][$rowcount]=$row['time'];
				$rowarray['work'][$rowcount]=$row['work'];
				$rowcount++;
			}
				#全体のグラフのピースを用意
				if($val['interval']=="15m"){
					$timedata=$this->Every15MinutesData();
				}elseif($val['interval']=="30m"){
					$timedata=$this->Every30MinutesData();
				}elseif($val['interval']=="1h"){
					$timedata=$this->EveryHoursData();
				}
				$dataPoints=$timedata;
				$dataPoints['title']=date('Y年m月の時間帯別作業量',strtotime($val['date']));
			}else{
				
			#該当データ0件
			$dataPoints=null;
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
				$dataPoints[$i]['date']="";
			}
			
			foreach($result as $row){
				$i=date('j',strtotime($row['date']));
				$dataPoints[$i]['y']=$row['number_of_work'];
			}
			
			return $dataPoints;
		}else{
			echo "該当するデータがありません。";
		}
	}
	
	function Every15MinutesData(){
		$data=[];
		$h='00';
		$m='00';
			for($i=1,$k=1;$i<=96;$i++,$k++){
				#桁調整
				if($m==0){
					$m='00';
				}
				#時間
				$time=$h.':'.$m;
				#配列の要素にする
				$data[$i]['y']=0;
				$data[$i]['name']=$time;
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
			for($i=1,$k=1;$i<=48;$i++,$k++){
				#桁調整
				if($m==0){
					$m='00';
				}
				#時間
				$time=$h.':'.$m;
				#配列の要素にする
				$data[$i]['y']=0;
				$data[$i]['name']=$time;
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
			for($i=1;$i<=24;$i++){
				#桁調整
				if($m==0){
					$m='00';
				}
				#時間
				$time=$h.':'.$m;
				#配列の要素にする
				$data[$i]['y']=0;
				$data[$i]['name']=$time;
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
