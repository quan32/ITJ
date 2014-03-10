<?php
	echo $this->element('search');
?>
<h1>Quản lý người dùng hiện tại</h1>

<table>
<tr>
	<th>ユーザ名</th>
	<th>氏名</th>
    <th>Role</th>	
	<th>生年月日</th>
	<th>住所</th>
	<th>電話番号</th>
    <th>クレジットカード情報(学生)</th>
    <th>銀行口座情報(先生)</th>
    <th>Lock</th>
    <th>pass</th>
	</tr>
<?php
	
	foreach ($users as $user) {
		if (!in_array($user["User"]["state"], array('deleted','locked'))){

		echo '<tr>';
			echo '<td>'.$user["User"]["username"].'</td>';
			echo '<td>'.$user["User"]["mail"].'</td>';
			echo '<td>'.$user["User"]["role"].'</td>';
			echo '<td>'.$user["User"]["address"].'</td>';
			echo '<td>'.$user["User"]["id"].'</td>';
			echo '<td>'.$user["User"]["id"].'</td>';
			echo '<td>'.$user["User"]["id"].'</td>';
			
	    echo '<td>';
       echo $this->Form->postLink('Delete', 
				array('controller'=>'users','action' => 'delete', $user["User"]["id"]),
				array('confirm'=>'Are you sure?'));

		echo '</td>';
		echo "<td>";
		echo $this->Html->link('Lock', 
				array('controller'=>'users','action' => 'lock', $user["User"]["id"]));
			
		echo "</td>";  
		echo "<td>";
		echo $this->Html->link('Reset', 
				array('controller'=>'users','action' => 'reset', $user["User"]["id"]));
			
		echo "</td>";    

		echo '</tr>';
	}
	}
?>
</table> 