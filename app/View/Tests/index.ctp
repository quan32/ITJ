<h1>各テスト</h1>
<table>
<tr>
	<th>ID</th>
	<th>タイトル</th>
	<th>テスト時間</th>
	<th>講義の ID</th>
	<th>作った時間</th>
	<th>管理</th>
</tr>
<?php
	foreach ($tests as $test) {
		echo '<tr>';
		//foreach ($test['Test'] as $value) {
			//var_dump($test);die;
		$value = $test['Test'];
			echo '<td>'.$value["id"].'</td>';
			echo '<td>'.$this->Html->link($value['name'],
				array('controller' => 'tests','action' => 'view',$value['id'])).'</td>';
			echo '<td>'.$value["time"].'</td>';
			echo '<td>'.$value["lecture_id"].'</td>';			
			echo '<td>'.$value["created"].'</td>';
			echo '<td>'.$this->Html->link('編集　｜', 
				array('action' => 'edit', $value["id"]));
			echo " ";
			echo $this->Form->postLink('　削除', 
				array('action' => 'delete', $value["id"]),
				array('confirm' => '本気？'));
			echo '</td>';
		//}
		echo '</tr>';
	}
?>
</table>
<?=	$this->Html->link('新しいテストを作成',
				array('controller' => 'tests','action' => 'add',$lecture_id)); ?>