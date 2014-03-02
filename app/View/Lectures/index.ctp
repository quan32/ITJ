<h1>Quan ly bai giang</h1>

<table>
<tr>
	<th>ID</th>
	<th>Title</th>
	<th>Cost</th>
	<th>Created Time</th>
	<th>Modified Time</th>
	<th>Detail</th>
	<th>Action</h1>
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
				array('controller'=>'lectures','action' => 'preview', 'xxx.pdf'));
			echo '</td>';

			echo '<td>';
			echo $this->Html->link('Edit', 
				array('action' => 'edit', $lecture["id"]));
			echo " ";
			echo $this->Html->link('Delete', 
				array('action' => 'delete', $lecture["id"]));
			// echo $this->Form->postLink('Delete', 
			// 	array('action' => 'delete',$value["id"]),
			// 	array('confirm' => 'Are you sure?'));
			echo '</td>';
		echo '</tr>';
	}
?>
</table> 