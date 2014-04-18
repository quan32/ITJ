<h1>バックアップ</h1>
<table>
<tr>
	<th>ID</th>
	<th>バックアップ</th>
	<th>復元</th>
	<th>削除</th>
</tr>
<?php
	foreach ($backups as $key => $value) {
		if ($value === '.' or $value === '..') continue;
		echo "<tr>";
		echo "<td>".($key+1)."</td>";
		echo "<td>".$value."</td>";
		echo "<td>".$this->Html->link('復元',
				array('controller' => 'manages','action' => 'restore',$value))."</td>";
		echo "<td>".$this->Html->link('削除',
				array('controller' => 'manages','action' => 'delete_backup',$value))."</td>";
		echo "</tr>";
	}
?>
</table>
<?php
	echo $this->Form->create(null, array(
	    'url' => array('controller' => 'manages', 'action' => 'backup')
	));
	echo $this->Form->end('現在のデータバックアップ');
?>