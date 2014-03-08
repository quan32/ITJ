<h1>Quan ly bai giang</h1>

<table>
<tr>
	<th>ID</th>
	<th>Title</th>
	<th>Cost</th>
	<th>Created Time</th>
	<th>Test</th>
	<th>View</th>
	<th>Action</th>
</tr>
<?php
	// debug($lectures);die;
	foreach ($lectures as $lecture) {
		echo '<tr>';
			echo '<td>'.$lecture['Lecture']["id"].'</td>';
			echo '<td>'.$lecture['Lecture']['name'].'</td>';
			echo '<td>'.$lecture['Lecture']['cost'].'</td>';
			echo '<td>'.$lecture['Lecture']['created'].'</td>';
			
			echo '<td>';
			echo $this->Html->link('List', 
				array('controller'=>'tests','action' => 'index',$lecture['Lecture']["id"]));
			echo '</td>';

			
			echo '<td>';
			echo $this->Html->link('View', 
				array('controller'=>'lectures','action' => 'view',$lecture['Lecture']["id"]));
			echo '</td>';

			echo '<td>';
			echo $this->Html->link('Edit', 
				array('action' => 'edit', $lecture['Lecture']["id"]));
			echo " ";
			echo $this->Form->postLink('Delete', 
				array('controller'=>'lectures','action' => 'delete',$lecture['Lecture']["id"]),
				array('confirm' => 'Are you sure?'));
			echo '</td>';
		echo '</tr>';
	}
?>
</table> 