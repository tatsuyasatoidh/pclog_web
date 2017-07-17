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
                echo "<tr>";
                echo "<th>No</th>";
                echo "<th>取得日</th>";
                echo "<th>企業名</th>";
                echo "<th>ユーザー</th>";
                echo "<th>作業数</th>";
                echo "<th>ログファイル</th>";
                echo "</tr>";
            
			foreach($result as $row){
                $funcPath="/lib/Controller/Download/getLogCsv.php";
                $path="log/".h($row['company_name'])."/".h($row['user_name'])."/".date('Ymd',strtotime(h($row['date'])));
                $href=$funcPath."/?log_path=".$path;
				$tr_count++;
				echo "<tr>";
				echo "<td>".$tr_count."</td>";
				echo "<td>".h($row['date'])."</td>";
				echo "<td>".h($row['company_name'])."</td>";
				echo "<td>".h($row['user_name'])."</td>";
				echo "<td>".h($row['number_of_work'])."</td>";
				echo "<td><a href='$href'>ログファイル</a></td>";
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