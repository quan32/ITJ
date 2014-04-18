<h1>関係する講義リスト</h1></br>
<table>
<tr>
	<th>ID</th>
	<th>タイトル</th>
	<th>作成時</th>
	<th>管理</th>
</tr>
<?php
	// debug($lectures);die;
	foreach ($lectures as $lecture) {
		echo '<tr>';
			echo '<td>'.$lecture['Lecture']["id"].'</td>';
			echo '<td>'.$lecture['Lecture']['name'].'</td>';
			echo '<td>'.$lecture['Lecture']['created'].'</td>';
			echo "<td>".$this->Html->link('詳しく',array('controller' => 'Lecture','action' => 'detail',$lecture['Lecture']['id']));
			echo '</td>';
		echo '</tr>';
	}
?>
</table> 