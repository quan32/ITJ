
<h1>Thread</h1>

<table>
<tr>
	<th>ID</th>
	<th>Title</th>
	<th>Owner</th>
	<th>Detail</th>
	<th>Action</th>
</tr>
<?php
	foreach ($threads as $thread) {
		echo '<tr>';
		foreach ($thread as $value) {
			echo '<td>'.$value["id"].'</td>';

			echo '<td>'.$this->Html->link($value['title'],
			 array('controller' => 'threads','action' => 'listPost',$value['id'])).'</td>';

			echo '<td>'.$value["username"].'</td>';

			echo '<td>';
			echo $this->Html->link('Detail', 
				array('action' => 'view', $value["id"]));
			echo '</td>';
			if($user_id === $value['user_id']){
				echo '<td>';
				echo $this->Html->link('Edit', 
				array('action' => 'edit', $value["id"]));
				echo " ";
				echo $this->Form->postLink('Delete', 
				array('action' => 'delete', $value["id"]));
				echo '</td>';
			}else{
				echo '<td></td>';
			}
			

		}
		echo '</tr>';
	}
?>
</table>
<?php
	echo $this->Html->link('Add thread', 
		array('controller' => 'threads', 'action' => 'add'));
?>