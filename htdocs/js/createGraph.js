/**
 * graphを作成する関数.js
 */


/** 作成関数*/
function createWorkPieChart($phpGraphInfo,$borderWorkCount,$chartId,$type)
{
	var $graphInfoArray =JSON.parse($phpGraphInfo);
	var $workdata = $graphInfoArray["work"];
	var $timedata = $graphInfoArray["time"];
	$workdata = arrayDivideByAmPm($workdata,$type);
	$timedata = arrayDivideByAmPm($timedata,$type);
	/** 作業達成時間と未達成時間の色わけを行う*/
	var $colorArray = createcolorArray($workdata,$borderWorkCount);
	/** pieチャート用の設定を返す関数に変数を渡す */
	var config = preparePieConfig($colorArray,$timedata);
	/** pieチャートの作成*/
	var ctx = document.getElementById($chartId).getContext("2d");
	window.myPie = new Chart(ctx, config);
	var colorNames = Object.keys(window.chartColors);
}

function arrayDivideByAmPm($graphInfo,$type)
{
	try{
		$result = [];
		console.log($type);
		$arg= ($type == "AM")? 0:48;
		for($i=0;$i<=47;$i++){
			$count = $i + $arg;
			console.log($count);
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
function preparePieConfig($colorArray,$timedata)
{
	
	console.log($colorArray);
    var config = {
			type: 'pie',
			data: {
					datasets: [{
							data: [
								10,10,10,10,10,10,
								10,10,10,10,10,10,
								10,10,10,10,10,10,
								10,10,10,10,10,10,
								10,10,10,10,10,10,
								10,10,10,10,10,10,
								10,10,10,10,10,10,
								10,10,10,10,10,10
							],
							backgroundColor:$colorArray,
					}],
					labels: [
						$timedata
					]
			},

			options: {
					responsive: true,
					 legend: {
							display: false
			 },
					tooltips: {
					mode: false
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
				console.log($val);
				console.log($colorData);
				console.log($val >= $borderWorkCount);
        $colorArray.push($colorData);
	});
	return $colorArray;
}