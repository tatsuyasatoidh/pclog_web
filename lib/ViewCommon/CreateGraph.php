<?php

class CreateGraph{
	
	function __construct() {
		require("lib\mysql\ConnectMysql.php"); 
	}
	function dailyGraph($val){
		$ConnectMysql = new ConnectMysql();
		$result=$ConnectMysql->loadDataIntoTmplogTable($val);

		$dataPoints = [];
		$rowcount=0;
		$h=0;#時間
		$i=0;#要素
		$rowarray=[];
		#作業量
		foreach($result as $row){
			$rowarray['time'][$rowcount]=$row['time'];
			$rowarray['work'][$rowcount]=$row['work'];
			$rowcount++;
		}
		
		for($h=0;$h<=24;$h++){
			if($h==0){
				$hour="00";
			}elseif($h<10){
				$hour="0".$h;
			}else{
				$hour=$h;
			}
			#全体のグラフのピースを用意
			if($val['interval']=="15m"){
				$m_length= 4;
				$m_times=15;
			}elseif($val['interval']=="30m"){
				$m_length= 2;
				$m_times=30;
			}
			
			#表示間隔が1時間のとき分数表示はしない
			if($val['interval'] != "1h"){
				$m_i=0;
				for($m=0;$m<$m_length;$m++){
					if($m==0){
						$min="00";
					}else{
						$m_i=$m_i+$i;
						$min=($m*$m_times);
					}
										
					$dataPoints[$m_i]['y']=1;
					$dataPoints[$m_i]['name']=$hour.":".$min;
					$dataPoints['color'][$m_i]="#ccc";

					if(in_array($dataPoints[$m_i]['name'],$rowarray['time'])){
						$arraysearch=array_search($dataPoints[$m_i]['name'],$rowarray['time']);
						$dataPoints[$m_i]['name']=$rowarray['time'][$arraysearch];
						#色付け
						if($dataPoints[$m_i]['name']>=1){
							$dataPoints['color'][$m_i]="blue";	
						}else{
							$dataPoints['color'][$m_i]="#ccc";
						}
					}

					if($m!=$m_length-1){
						$m_i++;
					}
				}
			}else{
				$min="00";
			}

			$i++;
		}
		$dataPoints['title']=date('Y年m月の時間帯別作業量',strtotime($val['date']));

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
}
