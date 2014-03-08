<!-- <h1>User list</h1>

<table>
<tr>
	<th>ID</th>
	<th>Username</th>
	<th>Fullname</ht>
	<th>Role</th>	
	<th>State</th>
	<th>Created Time</th>
</tr>
<?php
	foreach ($users as $user) {
		echo '<tr>';
		foreach ($user as $value) {
			echo '<td>'.$value["id"].'</td>';
			echo '<td>'.$value["username"].'</td>';
			echo '<td>'.$value["fullname"].'</td>';
			echo '<td>'.$value["role"].'</td>';
			echo '<td>'.$value["state"].'</td>';			
			echo '<td>'.$value["created"].'</td>';
		}
		echo '</tr>';
	}
?>
</table> -->