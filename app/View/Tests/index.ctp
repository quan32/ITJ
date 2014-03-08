<h1>Tests List</h1>
<table>
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Time</th>
	<th>Lecture ID</th>
	<th>Created Time</th>
	<th>Action</th>
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
			echo '<td>'.$this->Html->link('Edit', 
				array('action' => 'edit', $value["id"]));
			echo " ";
			echo $this->Form->postLink('Delete', 
				array('action' => 'delete', $value["id"]),
				array('confirm' => 'Are you sure?'));
			echo '</td>';
		//}
		echo '</tr>';
	}
?>
</table>
<?=	$this->Html->link('Add new test',
				array('controller' => 'tests','action' => 'add',$lecture_id)); ?>