<?php
	if($role=='student'){
		//home page of student
		echo '<h1>Student</h1>';
	}else if($role =='teacher'){
		//home page of teacher
		echo '<h1>Teacher</h1>';
		echo $this->Html->link('Add new Lecture', array('controller'=>'Lectures', 'action'=>'add'));
	}else{
		//home page of admin
		echo '<h1>Admin</h1>';
	}

?>








<!-- <h1>Blog Post</h1>

<table>
<tr>
	<th>ID</th>
	<th>Username</th>
	<th>Role</th>
	<th>Created Time</th>
</tr>
<?php
	foreach ($users as $user) {
		echo '<tr>';
		foreach ($user as $value) {
			echo '<td>'.$value["id"].'</td>';

			echo '<td>'.$this->Html->link($value['username'],
			 array('controller' => 'users',
			 	'action' => 'view',
			 	$value['id'])).'</td>';

			echo '<td>';
			echo $this->Html->link('Edit', 
				array('action' => 'edit', $value["id"]));
			echo " ";
			echo $this->Form->postLink('Delete', 
				array('action' => 'delete', $value["id"]),
				array('confirm' => 'Are you sure?'));
			echo '</td>';

			echo '<td>'.$value["created"].'</td>';
		}
		echo '</tr>';
	}
?>
</table> -->