<table>
	<tr>
		<th>ID</th>
		<th>Username</th>
		<th>Created Time</th>
		<th>Modified Time</th>
	</tr>
	
	<?php
		foreach ($user as $value) {
			echo '<td>'.$value["id"].'</td>';
			echo '<td>'.$value["username"].'</td>';
			echo '<td>'.$value["created"].'</td>';
			echo '<td>'.$value["modified"].'</td>';
		}
	?>
		
	
</table>