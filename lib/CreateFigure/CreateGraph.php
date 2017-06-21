<?php

include_once dirname(__FILE__)."/../Dao/TmpLogDao.php" ; 
include_once dirname(__FILE__)."/../Dao/pcLogDao.php" ; 
include_once dirname(__FILE__)."/../Common/DBConn.php" ; 


class CreateGraph{
    private $Ymd;
    private $user;
    private $company;
    private $interval;
    private $result;
    
    private function setVal($date, $company, $user, $interval){
        $this->Ymd      = $date;
        $this->company  = $company;
        $this->user     = $user;
        $this->interval = $interval;
    }
    
    private function create()
    {

        $TmpLogDao = new TmpLogDao();
        $dataPoints = [];
        
        #時間ごとの作業量０の配列を作成。
        $tmplateVal=$this->tmplateVal($this->interval);
        
        #一時テーブルから検索日とユーザー名の組み合わせのものを削除。
        $TmpLogDao->delete($this->user, $this->Ymd);
        
        #一時テーブルから検索日とユーザー名の組み合わせのものを格納。
        $result=$TmpLogDao->loadData($this->user, $this->Ymd);

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
        $this->result = $dataPoints;
        
        return true;
    }
	
    public function getResult()
    {
        return $this->result;
    }
    
    /*結果の合計を取得*/
    public function getTotalWork(){
        $result = $this->result;
        return array_sum($result['work']);
    }
    
    /* 15分グラフ */
    public function fifteenthMin($val)
    {
        $this->setVal($val['date'], $val['company'], $val['user'],"15m");
        $result = $this->create();
        
        if(!$result){
            return $this->dataNotAvailable();
        }else{
            return $result;
        }
    }
    
    /* 30分グラフ */
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
    
    /* 1時間グラフ */
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
    $pclogDao = new pclogDao();
		if(isset($val['month'])){
			$val['start_date']=$val['month']."-01";
			$val['end_date']=$val['month']."-31";
		}else{
			$val['start_date']="";
			$val['end_date']="";
		}
		$result=$pclogDao->getAllWhere($val['company'], $val['user'], $val['start_date'], $val['end_date'] );
      
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
    var_dump("data not available");
    return false;  
  }
    
	}
