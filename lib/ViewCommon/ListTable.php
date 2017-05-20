<?php
class ListTable{
	public $ConnectMysql;
	
	function __construct() {
		require("lib\mysql\ConnectMysql.php"); 
	}

	function pcLogList($val){
		$ConnectMysql = new ConnectMysql();
		$result=$ConnectMysql->selectPclogJoinUserJoinCompany($val);
		if($result){
			$tr_count=0;
			echo 
<<< EOM
				<tr>
				<th>No</th>
				<th>取得日</th>
				<th>企業名</th>
				<th>ユーザー</th>
				<th>作業数</th>
				<th>ログファイル</th>
				</tr>
EOM
;
			foreach($result as $row){
				$tr_count++;
				echo "<tr>";
				echo "<td>".$tr_count."</td>";
				echo "<td>".h($row['date'])."</td>";
				echo "<td>".h($row['company_name'])."</td>";
				echo "<td>".h($row['user_name'])."</td>";
				echo "<td>".h($row['number_of_work'])."</td>";
				echo "<td>"."ログファイル"."</td>";
				echo "</tr>";
			}
		}else{
				$this->noData();
		}
		
	}
		function noData(){
			echo "該当データは0件です。";
		}
}