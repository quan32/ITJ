<h1>講義管理</h1><br />

<table>
<tr>
	<th>ID</th>
	<th>タイトル</th>
	<th>作成時</th>
	<th>テスト</th>
	<th>表現</th>
	<th>管理</th>
</tr>
<?php
	// debug($lectures);die;
	foreach ($lectures as $lecture) {
		echo '<tr>';
			echo '<td>'.$lecture['Lecture']["id"].'</td>';
			echo '<td>'.$lecture['Lecture']['name'].'</td>';
			echo '<td>'.$lecture['Lecture']['created'].'</td>';
			
			echo '<td>';
			echo $this->Html->link('リスト', 
				array('controller'=>'tests','action' => 'index',$lecture['Lecture']["id"]));
			echo '</td>';

			
			echo '<td>';
			echo $this->Html->link('表現', 
				array('controller'=>'lectures','action' => 'view',$lecture['Lecture']["id"]));
			echo '</td>';

			echo '<td>';
			echo $this->Html->link('編集　', 
				array('action' => 'edit', $lecture['Lecture']["id"]));
			echo " ";
			echo $this->Form->postLink('　削除', 
				array('controller'=>'lectures','action' => 'delete',$lecture['Lecture']["id"]),
				array('confirm' => '本気？'));
			echo '</td>';
		echo '</tr>';
	}
?>
</table> 