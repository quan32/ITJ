<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
<?php echo $this->Html->script('jquery-1.10.2.min');?>
<style type="text/css">
	.correct{
		color:red;
	}
	table{
		border-collapse:collapse;
	}
	table, td, th{
		border: 1px solid black;
	}
	td{
		text-align: right;
	}
</style>
<h1>あなたの選択</h1>
<?php
	//Hien thi form with answered choice
	$count = 1;
	foreach ($tests as $question) {
		echo "<br>";
		echo $count.". ".$question['qs']."<br>";
		//hidden field
		echo $this->Form->input($count.'.ks', array('value'=>$question['ks'] ,'type'=>'hidden') );
		$attributes = array(
		    'legend' => false,
		    'value' => $result[$count]['answer'],
		    'disabled' => true,
		    'separator' => '<br>'
		);
		echo $this->Form->radio($count.'.answer', $question['s'], $attributes);
		$count++;
	}
	echo $this->Form->input('num_row', array('value'=>$count ,'type'=>'hidden') );
?>
<hr>
<h1>テストの結果</h1>
<?php
	//Tinh diem
	$count = 1;
	$tongdiem =0;
	$caudung = 0;
	$diem = 0;
	foreach ($tests as $question) {
		if($result[$count]['answer'] == strval($question['ks'])){
			$caudung++;
			$diem+=$question['point'];
		}
		$count++;
		$tongdiem+=$question['point'];
	}
echo "正しい答え: ".$caudung."/".($count-1)."<br>";
echo "点数: ".$diem."/".$tongdiem." ~ ".round($diem/$tongdiem*100,0)."<br>";
?>
<table>
<tr>
	<th>順番</th>
	<th>点数</th>
	<th>正しい１/違い０</th>
	<th>最後の点数</th>
</tr>
<?php
	$count = 1;
	foreach ($tests as $question) {
		echo "<tr>";
		echo "<td>".$count."</td>";
		echo "<td>".$question['point']."</td>";
		$correct = $result[$count]['answer'] == strval($question['ks']) ? 1: 0;
		echo "<td>".$correct."</td>";
		echo "<td>".($correct*$question['point'])."</td>";
		echo "</tr>";
		$count++;
	}	
?>
<tr>
	<td>全部の点数</td>
	<td><?=$tongdiem;?></td>
	<td><?=$caudung;?>/<?=$count-1;?></td>
	<td><?=$diem;?></td>
</tr>
</table>


<script type="text/javascript">
	$(document).ready(function(){
		var num_row = $("[name='data[num_row]']").val();
		for(i=1;i<=num_row;i++){
			answer_value = $("#"+i+"Ks").val();
			$("label[for='"+i+"Answer"+answer_value+"']").addClass("correct");
		}
	});
</script>