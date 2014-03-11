<h1>講義の管理</h1>

<table>
<tr>
	<th>ID</th>
	<th>タイトル</th>
	<th>ユーザー名</th>
	<th>作成した日時</th>
	<th>更新日時</th>
	<th>詳細</th>
	<th>管理</h1>
</tr>
<?php
	
	foreach ($lectures as $lecture) {

   if (!in_array($lecture["User1"]["state"], array('deleted','locked'))) {
   		echo '<tr>';
			echo '<td>'.$lecture["Lecture"]["id"].'</td>';
			echo '<td>'.$lecture["Lecture"]['name'].'</td>';
           
            
			echo '<td>'.$lecture["User1"]['username'].'</td>';
			echo '<td>'.$lecture["Lecture"]['created'].'</td>';
			echo '<td>'.$lecture["Lecture"]['modified'].'</td>';

			echo '<td>';
			echo $this->Html->link('表現', 
			array('controller'=>'lectures','action' => 'view', $lecture["Lecture"]["id"]));
			echo '</td>';

			echo '<td>';
			echo $this->Form->postLink('削除', 
				array('controller'=>'lectures','action' => 'delete', $lecture["Lecture"]["id"]),
				array('confirm'=>'本気？'));
			
			
			echo '</td>';
		echo '</tr>';
	

   }
	}
?>
</table> 