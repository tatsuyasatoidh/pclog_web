/**
 * 作業量正誤表を作成するファイル
 */

/**
 * @param array $timeArray 時間情報の配列
 * @param array $workArray 作業量配列
 * @param int $borderWorkCount 作業量境界値
 * @param stirng $errataId 正誤表を作成するHTMLのID
 */
function createErrata($phpGraphInfo,$borderWorkCount,$errataId)
{
	var $graphInfoArray =JSON.parse($phpGraphInfo);
	var $workArray = $graphInfoArray["work"];
	var $timeArray = $graphInfoArray["time"];
	$borderWorkCount = parseInt($borderWorkCount);
	var $attendanceArray = createAttendanceArray($workArray,$borderWorkCount);
	var $attendanceboolean = [];
	console.log($attendanceArray);
	for($i = 0; $i<96;$i++){
			$("#"+$errataId).append("<tr><td>" + $timeArray[$i] + "</td><td>" + $workArray[$i] + "</td><td>"+$attendanceArray[$i]+"</td></tr>");
			if($attendanceArray[$i] == "○"){
					$attendanceboolean.push("○");
			}
	 }
}

/**
 * $workdataのデータの値を判断して時間ごとに達成したかを確認配列を作成
 * @param array Array　$workdata 作業量配列
 * @param array INt　$borderWorkCount 作業量の境界線
 */
function createAttendanceArray($workdata,$borderWorkCount)
{
	$borderWorkCount = parseInt($borderWorkCount);
	/** 正誤配列*/
	var $attendanceArray = [];
	 $workdata.forEach(function($val){     
        var $attendance =(($val >= $borderWorkCount)?'○':'×');      
        $attendanceArray.push($attendance);
    });
	return $attendanceArray;
}