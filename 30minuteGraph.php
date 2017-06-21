<?php
/*
* 30分ごとのグラフ　view
*
*/
include_once 'Create30minGraph.php';
include_once 'ValueCheck.php';
ini_set( 'display_errors', 1 );

$Create30minGraph= new Create30minGraph();	

if(isset($_POST['submit'])){
	
	$val['company']=$_POST['company'];
	$val['user_name']=$_POST['user_name'];
	$val['date']=$_POST['date'];
	$val['interval']=$_POST['interval'];

}else{
	$val['company']="";
	$val['user_name']="";
	$val['date']="";
	$val['interval']="";
}
#boolean
$dataPoints=$Create30minGraph->create($val);
;?>
<form method="post">
  <label for="company">企業名</label>
  <input type="text" name="company" value="<?php echo $val['company'] ;?>">
  <label for="user_name" >ユーザー</label>
  <input type="text" name="user_name" id="user_name" value="<?php echo $val['user_name'] ;?>" required>
  <label>年月日</label>
  <input type="date" name="date" value="<?php echo $val['date'] ;?>" required>
  <label>表示間隔</label>
  <select name="interval">
    <option value="30m">30分間隔</option>
    <option value="30m">30分間隔</option>
    <option value="1h">1時間隔</option>
  </select>
  <button id="submit" name="submit" type="submit" class="btn btn-primary" value="submit">検索</button>
</form>
<div class="panel">
  <div class="panel-heading">
  <?php if(isset($dataPoints['time'])):?>
  <h3 class="panel-title" style="color: #000;"><i class="fa fa-bar-chart-o"></i><?php echo $dataPoints['title'];?></h3>
  </div>
  <div class="panel-body"><div style="overflow:scroll">
	<table>
		<tr>
			<th style="border: 1px solid #000; text-align:center;">時間</th>
		<?php for($i=0;$i<count($dataPoints['time']);$i++): ?>
			<th style="border: 1px solid #000; text-align:center;"><?php echo $dataPoints['time'][$i];?></th>
		<?php endfor;?>
		</tr>
		<tr>
			<th style="border: 1px solid #000; text-align:center;">勤務</th>
		<?php for($i=0;$i<count($dataPoints['time']);$i++): ?>
			<td style="border: 1px solid #000; text-align:center;"><?php $work=$dataPoints['work'][$i]>=35?'○':'×'; echo $work;?><?= $work=$dataPoints['work'][$i] ;?></td>
		<?php endfor;?>
		</tr>
	</table>
</div></div>
  <?php else:?>
  <p style="color:#000">該当データがありません。</p>
  <?php endif;?>
</div>