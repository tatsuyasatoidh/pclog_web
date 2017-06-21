<?php
include_once dirname(__FILE__)."/../mysql/ConnectMysql.php"; 
include_once dirname(__FILE__)."/../Dao/pclogDao.php"; 

class ListTable{
	public $ConnectMysql;
	
	function pcLogList($val){
      $PclogDao = new PclogDao();
      
    if(!($val["company"] == null and $val["user"]==null and $val["start_date"]==null and $val["end_date"]==null)){
        
        $result=$PclogDao->getAllWhere($val['company'], $val['user'], $val['start_date'], $val['end_date']);
        
    }  else { 
        $result=$PclogDao->getAll();
    }
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