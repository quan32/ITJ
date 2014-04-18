<h1>新ユーザ確認</h1>

<table>
<tr>
	<th>ユーザ名</th>
	<th>氏名</th>
	<th>役割</th>
	<th>生年月日</th>
	<th>住所</th>
	<th>電話番号</th>
    <th>クレジットカード情報(学生)</th>
    <th>銀行口座情報(先生)</th>
    <th>変更</th>
    <th>確認</th>
	</tr>
<?php
	
	foreach ($users as $user) {
		echo '<tr>';
			echo '<td>'.$user["User"]["username"].'</td>';
			echo '<td>'.$user["User"]["fullname"].'</td>';
			echo '<td>'.$user["User"]["role"].'</td>';
			echo '<td>'.$user["User"]["date_of_birth"].'</td>';
			echo '<td>'.$user["User"]["address"].'</td>';
			echo '<td>'.$user["User"]["mobile_No"].'</td>';
			echo '<td>'.$user["User"]["credit_card_No"].'</td>';
			echo '<td>'.$user["User"]["bank_acc"].'</td>';
			echo '<td>';
			echo $this->Html->link('変更', 
                array('controller'=>'manages','action' => 'editinfo', $user["User"]["id"]));
            echo '</td>'; 
	        echo '<td>';
            echo $this->Form->create('User', array('url' => array('controller' => 'manages', 'action' => 'accept'))); 
            echo $this->Form->hidden('id', array('value' =>$user["User"]["id"] ));
            echo $this->Form->hidden('state', array('value' => 'normal'));
           
            echo $this->Form->end('承認');
            echo $this->Form->create('User', array('url' => array('controller' => 'manages', 'action' => 'accept'))); 
            echo $this->Form->hidden('id', array('value' =>$user["User"]["id"] ));
            echo $this->Form->hidden('state', array('value' => 'rejected'));
           
            echo $this->Form->end('拒否');
            
          
		    echo '</td>';

		echo '</tr>';
	}
?>
</table> 


