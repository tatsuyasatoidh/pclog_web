<div style="overflow:scroll">
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
			<td style="border: 1px solid #000; text-align:center;"><?php $work=$dataPoints['work'][$i]>=35?'○':'×'; echo $work;?></td>
		<?php endfor;?>
		</tr>
	</table>
</div>