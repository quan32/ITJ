<h1>ユーザー管理</h1>

<table>
<tr>
	<th>ユーザ名</th>
	<th>氏名</th>
    <th>資格</th>	
	<th>生年月日</th>
	<th>住所</th>
	<th>電話番号</th>
    <th>スタテス</th>
    <th>管理</th>
	</tr>
<?php
	
	foreach ($users as $user) {
		if (!in_array($user["User"]["state"], array('deleted','locked'))){

		echo '<tr>';
			echo '<td>'.$user["User"]["username"].'</td>';
			echo '<td>'.$user["User"]["fullname"].'</td>';
			echo '<td>'.$user["User"]["role"].'</td>';
			echo '<td>'.$user["User"]["date_of_birth"].'</td>';
			echo '<td>'.$user["User"]["address"].'</td>';
			echo '<td>'.$user["User"]["mobile_No"].'</td>';
		   	echo '<td>'.$user["User"]["bank_acc"].'</td>';
			
	    echo '<td>';
       echo $this->Form->postLink('削除 | ', 
				array('controller'=>'users','action' => 'delete', $user["User"]["id"]),
				array('confirm'=>'本気？'));

		
		echo $this->Html->link('ロック | ', 
				array('controller'=>'users','action' => 'lock', $user["User"]["id"]));
			
		
		echo $this->Html->link('Pリセット', 
				array('controller'=>'users','action' => 'reset', $user["User"]["id"]));

		if($user["User"]["role"]=="teacher")
			echo $this->Html->link(' | Vリセット', 
				array('controller'=>'users','action' => 'resetVerifyCode', $user["User"]["id"]));
			
		echo "</td>";    

		echo '</tr>';
	}
	}
?>
</table> 