<h1>Quản lý người dùng mới</h1>

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
	</tr>
<?php
	
	foreach ($users as $user) {
		echo '<tr>';
			echo '<td>'.$user["User"]["username"].'</td>';
			echo '<td>'.$user["User"]["mail"].'</td>';
			echo '<td>'.$user["User"]["role"].'</td>';
			echo '<td>'.$user["User"]["address"].'</td>';
			echo '<td>'.$user["User"]["id"].'</td>';
			echo '<td>'.$user["User"]["id"].'</td>';
			echo '<td>'.$user["User"]["id"].'</td>';
			
	        echo '<td>';
            echo $this->Form->create('User', array('url' => array('controller' => 'manages', 'action' => 'accept'))); 
            echo $this->Form->hidden('id', array('value' =>$user["User"]["id"] ));
            echo $this->Form->hidden('state', array('value' => 'normal'));
           
            echo $this->Form->end('Accept');

		    echo '</td>';

		echo '</tr>';
	}
?>
</table> 