
<?php
class CommonData{
	function Every15MinutesData(){
		$data=[];
		$h='00';
		$m='00';
			for($i=1,$k=1;$i<=94;$i++,$k++){
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
	
}
