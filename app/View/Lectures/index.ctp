<h1>Quan ly bai giang</h1>

<table>
<tr>
	<th>ID</th>
	<th>Title</th>
	<th>Cost</th>
	<th>Created Time</th>
	<th>Modified Time</th>
	<th>View</th>
	<th>Action</th>
</tr>
<?php
	// var_dump($lectures);
	foreach ($lectures as $lecture) {
		echo '<tr>';
			echo '<td>'.$lecture["id"].'</td>';
			echo '<td>'.$lecture['name'].'</td>';
			echo '<td>'.$lecture['cost'].'</td>';
			echo '<td>'.$lecture['created'].'</td>';
			echo '<td>'.$lecture['modified'].'</td>';

			echo '<td>';
			echo $this->Html->link('View', 
				array('controller'=>'lectures','action' => 'preview',$lecture["id"]));
			echo '</td>';

			echo '<td>';
			echo $this->Html->link('Edit', 
				array('action' => 'edit', $lecture["id"]));
			echo " ";
			echo $this->Form->postLink('Delete', 
				array('controller'=>'lectures','action' => 'delete',$lecture["id"]),
				array('confirm' => 'Are you sure?'));
			echo '</td>';
		echo '</tr>';
	}
?>
</table> 