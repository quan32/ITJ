<h1>Blog Post</h1>

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
</table>