<table>
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Owner</th>
		<th>Description</th>
		<th>Created Time</th>
	</tr>
	
	<?php
		foreach ($thread as $value) {
			echo '<td>'.$value["id"].'</td>';
			echo '<td>'.$value["title"].'</td>';
			echo '<td>'.$value["username"].'</td>';
			echo '<td>'.$value["description"].'</td>';
			echo '<td>'.$value["created"].'</td>';
		}
	?>
		
	
</table>