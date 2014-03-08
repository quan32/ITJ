<h1>Quan ly bai giang</h1>

<table>
<tr>
	<th>ID</th>
	<th>Title</th>
	<th>User</th>
	<th>Created Time</th>
	<th>Modified Time</th>
	<th>Detail</th>
	<th>Action</h1>
</tr>
<?php
	
	foreach ($lectures as $lecture) {

   if (!in_array($lecture["User1"]["state"], array('deleted','locked'))) {
   		echo '<tr>';
			echo '<td>'.$lecture["Lecture"]["id"].'</td>';
			echo '<td>'.$lecture["Lecture"]['name'].'</td>';
           
            
			echo '<td>'.$lecture["User1"]['username'].'</td>';
			echo '<td>'.$lecture["Lecture"]['created'].'</td>';
			echo '<td>'.$lecture["Lecture"]['modified'].'</td>';

			echo '<td>';
			echo $this->Html->link('View', 
				array('controller'=>'lectures','action' => 'preview', //$lecture['Source']['0']['filename']
				));
			echo '</td>';

			echo '<td>';
			echo $this->Html->link('Delete', 
				array('controller'=>'lectures','action' => 'delete', $lecture["Lecture"]["id"]));
			
			
			echo '</td>';
		echo '</tr>';
	

   }
	}
?>
</table> 