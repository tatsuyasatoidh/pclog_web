/**
 * graphを作成する関数.js
 */

//
///** 作成関数*/
//function createWorkPieChart($phpGraphInfo,$borderWorkCount,$chartId,$type)
//{
//	var $graphInfoArray =JSON.parse($phpGraphInfo);
//	var $workdata = $graphInfoArray["work"];
//	var $timedata = $graphInfoArray["time"];
////	$workdata = arrayDivideByAmPm($workdata,$type);
////	$timedata = arrayDivideByAmPm($timedata,$type);
//	/** 作業達成時間と未達成時間の色わけを行う*/
//	var $colorArray = createcolorArray($workdata,$borderWorkCount);
//	/** pieチャート用の設定を返す関数に変数を渡す */
//	var config = preparePieConfig($colorArray,$timedata);
//	/** pieチャートの作成*/
//	var ctx = document.getElementById($chartId).getContext("2d");
//	window.myPie = new Chart(ctx, config);
//	var colorNames = Object.keys(window.chartColors);
//}

/** 1hグラフ作成関数*/
function createWorkPieChartHour($hourworkArray,$achiveArray,$timedata,$chartId)
{
	/** pieチャート用の設定を返す関数に変数を渡す */
	var config = preparePieConfigHour($hourworkArray,$timedata);
	/** pieチャートの作成*/
	var ctx = document.getElementById($chartId).getContext("2d");
	window.myPie = new Chart(ctx, config);
	var colorNames = Object.keys(window.chartColors);
}

function getTimeArray($phpGraphInfo)
{
	var $graphInfoArray =JSON.parse($phpGraphInfo);
	var $timedata = $graphInfoArray["time"];
	return $timedata;
}

function getWorkArray($phpGraphInfo)
{
	var $graphInfoArray =JSON.parse($phpGraphInfo);
	var $workdata = $graphInfoArray["work"];
	return $workdata;
}

function arrayDivideByAmPm($graphInfo,$type)
{
	try{
		$result = [];
		console.log($type);
		$arg= ($type == "AM")? 0:48;
		for($i=0;$i<=23;$i++){
			$count = $i + $arg;
			$result.push($graphInfo[$count]);
		}
	}catch($e){
	}finally{
		return $result
	}
}


/**
 * pieチャート用の設定作成関数
 * @param array $colorArray　色情報の配列
 * @param array $colorArray　色の配列
 */
//function preparePieConfig($colorArray,$timedata)
//{
//	
//    var config = {
//			type: 'polarArea',
//			data: {
//					datasets: [{
//							data: [
//								10,10,10,10,10,10,
//								10,10,10,10,10,10,
//								10,10,10,10,10,10,
//								10,10,10,10,10,10
//							],
//							backgroundColor:$colorArray,
//					}],
//					labels: [
//						$timedata
//					]
//			},
//
//			options: {
//					responsive: true,
//					 legend: {
//							display: false
//			 },
//					tooltips: {
//					mode: false
//					},
//			}
//		};
//	return config;
//};

/**
 * pieチャート用の設定作成関数
 * @param array $colorArray　色情報の配列
 * @param array $colorArray　色の配列
 */
function preparePieConfigHour($hourworkArray,$timedata)
{
	var $colorArray = [];
	var $count = 0;
	for($i = 0;$i <$hourworkArray.length; $i++){
		if($hourworkArray[$i] != '0'){
			$count++;
			if($count ==0){
				$colorArray[$i] = "#2ecc71";
			}else if($count ==1){
				$colorArray[$i] = "#3498db";
			}else if($count ==2){
				$colorArray[$i] = "#9b59b6";
			}else if($count ==3){
				$colorArray[$i] = "#f1c40f";
			}else if($count ==4){
				$colorArray[$i] = "#e74c3c";
			}else{
				$colorArray[$i] = "#34495e";
				$count =0;
			}
		}
	}
    var config = {
        type: 'pie',
        data: {
            datasets: [{
                data: $hourworkArray,
                backgroundColor: $colorArray,
                label: 'Dataset 1'
            }],
            labels: $timedata
        },
        options: {
            responsive: true,
						legend: {
							display: false
						},
        }
    };
	return config;
};

/**
 * $workdataのデータの値を判断してpieチャート用色の配列を作成関数
 * @param array Array　$workdata 作業量配列
 * @param array INt　$borderWorkCount 作業量の境界線
 */
function createcolorArray($workdata,$borderWorkCount)
{
	$borderWorkCount = parseInt($borderWorkCount);
	/** 色配列*/
	var	$colorArray = [];
	$workdata.forEach(function($val){
        var $colorData =(($val >= $borderWorkCount)?'#2fa4e7':'#c9c9c9'); 
	});
	return $colorArray;
}

/**
 * データの値を判断してpieチャート用色の配列を作成関数
 * @param array Array　$workdata 作業量配列
 * @param array INt　$borderWorkCount 作業量の境界線
 */
function createcolorArray($workdata,$borderWorkCount)
{
	$borderWorkCount = parseInt($borderWorkCount);
	/** 色配列*/
	var	$colorArray = [];
	$workdata.forEach(function($val){
        var $colorData =(($val >= $borderWorkCount)?'#2fa4e7':'#c9c9c9');  
        $colorArray.push($colorData);
	});
	return $colorArray;
}

/**
 * 棒グラフのオプション
 */
function barGraphOption(){
		var $option ={                             //◆オプション
			responsive: true,                  //グラフ自動設定
			legend: {                          //凡例設定
					display: false                 //表示設定
		 },
			scales: {                          //軸設定
					yAxes: [{                      //y軸設定
							display: true,             //表示設定
							scaleLabel: {              //軸ラベル設定
								 display: true,          //表示設定
								 fontSize: 18               //フォントサイズ
							},
							ticks: {                      //最大値最小値設定
									min: 0,                   //最小値
									max: 1800,                  //最大値
									fontSize: 18,             //フォントサイズ
									stepSize: 900               //軸間隔
							},
					}],
					xAxes: [{                         //x軸設定
							display: true,                //表示設定
							barPercentage: 1,           //棒グラフ幅
							categoryPercentage: 1,      //棒グラフ幅
							scaleLabel: {                 //軸ラベル設定
								 display: true,             //表示設定
								 fontSize: 12               //フォントサイズ
							},
							ticks: {
									fontSize: 18             //フォントサイズ
							},
					}],
			},
			layout: {                             //レイアウト
					padding: {                          //余白設定
							left: 10,
							right: 10,
							top: 0,
							bottom: 0
					}
			}
	}
		return $option;
}
