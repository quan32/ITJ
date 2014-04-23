<h1 padding-bottom="5px">請求書 </h1>

<?php 

echo $this->Form->create('Manage', array('url' => array('controller' => 'manages', 'action' => 'oder'))); 
echo $this->Form->input('year', array('label'=>'年', 'options'=>array('2014'=>'2014')));
echo $this->Form->input('month', array('label'=>'月', 'options'=>array('1'=>'01','2'=>'02','3'=>'03','4'=>'04','5'=>'05','6'=>'06','7'=>'07','8'=>'08','9'=>'09','10'=>'10','11'=>'11','12'=>'12')));
echo $this->Form->hidden('print', array('value' => false));
echo $this->Form->end(array('label'=>'表現'));

if ($alls != null) {
	$data1s=explode(",", $data1); 
	$datas=explode(",", $data); 
?>

<table>
<!-- <tr>
	<th>ユーザID</th>
	<th>氏名</th>
	<th>お金</th>
	<th>アドレス</th>
	<th>携帯電話</th>
	<th>クレジットカード</th>
	<th>銀行預金口座</th>
</tr> -->

<?php

echo '<tr>';
foreach ($data1s as $tmp ) 
{
 echo '<td>'.$tmp.'</td>';
}
echo '</tr>';


foreach ($alls as $all ) {
$id=$all["Lecture"]["user_id"];
//debug($users);
echo '<tr>';
            echo '<td>'.$users[$id]["User"]["id"].'</td>';
            echo '<td>'.$users[$id]["User"]["fullname"].'</td>';
			echo '<td>'.$all[0]["total"].'</td>';
			echo '<td>'.$users[$id]["User"]["address"].'</td>';
			echo '<td>'.$users[$id]["User"]["mobile_No"].'</td>';
			echo '<td>'.'54'.'</td>';
			//echo '<td>'.$users[$id]["User"]["credit_card_No"].'</td>';
			echo '<td>'.$users[$id]["User"]["bank_acc"].'</td>';
			
echo '</tr>';          
}

foreach ($alls_st as $all ) {
$id=$all["Register"]["user_id"];

echo '<tr>';
            echo '<td>'.$users_st[$id]["User"]["id"].'</td>';
            echo '<td>'.$users_st[$id]["User"]["username"].'</td>';
			echo '<td>'.$all[0]["total"].'</td>';
			echo '<td>'.$users_st[$id]["User"]["address"].'</td>';
			echo '<td>'.$users_st[$id]["User"]["mobile_No"].'</td>';
			echo '<td>'.'18'.'</td>';
			echo '<td>'.$users_st[$id]["User"]["credit_card_No"].'</td>';
			//echo '<td>'.$users_st[$id]["User"]["bank_acc"].'</td>';
			
echo '</tr>';          

}

echo '<tr>';
foreach ($datas as $tmp ) 
{
 echo '<td>'.$tmp.'</td>';
}
echo '</tr>';

echo '</table>';
echo $this->Form->create('Manage', array('url' => array('controller' => 'manages', 'action' => 'oder'))); 
echo $this->Form->hidden('month', array('value' => $month));
echo $this->Form->hidden('year', array('value' => $year));
echo $this->Form->hidden('print', array('value' => true));           
echo $this->Form->end('作成');

}
else
{
echo "<div style='color:red'>データがない</div>";
}

?>
<style type="text/css">
	label{
		margin-right:5px;
	}
</style>