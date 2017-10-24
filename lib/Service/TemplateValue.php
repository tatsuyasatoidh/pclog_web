<?php
namespace lib\Service;

class_exists('lib\Controller\ParentController') or require_once  $_SERVER['DOCUMENT_ROOT'].'/lib/Controller/ParentController.php';

class TemplateValue{

    /* */
    public function __construct($interval){
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
      return true;
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

   /*抽出結果が0件*/
  protected function dataNotAvailable(){
    parent::setInfoLog("data not available");
    return false;  
  }
    
	}
