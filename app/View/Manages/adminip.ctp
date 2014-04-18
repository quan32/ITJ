
<table>
<tr>
	<th>ID</th>
	<th>IP</th>
	<th>ユーザー</th>
	<th>編集</th>
	
	
</tr>
<?php
	
	foreach ($datas as $data) {
   // var_dump($ip["Ip"]); die();
   
		echo '<tr>';
			echo '<td>'.$data["Ip"]["id"].'</td>';
			echo '<td>'.$data["Ip"]['ip'].'</td>';
           
            
			echo '<td>'.$data["User"]['username'].'</td>';
			
			echo '<td>';
			echo $this->Html->link('Edit', 
			array('controller'=>'manages','action' => 'editip',$data["Ip"]["id"]));
			echo '</td>';

			
		echo '</tr>';
	}
?>
</table> 