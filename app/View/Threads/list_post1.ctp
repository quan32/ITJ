<?php
echo '<table>';
	foreach ($posts as $post) {
			echo '<tr>';
			foreach ($post as $value) {
				echo '<td>'.$value["username"].'</td>';

				echo '<td>'.$value["body"].'</td>';

				if($user_id === $value["user_id"]){
				echo '<td>';
				echo $this->Html->link('Edit', 
					array('controller'=>'posts','action' => 'edit', $value["id"]));
				echo " ";
				echo $this->Form->postLink('Delete', 
					array('controller'=>'posts','action' => 'delete', $value["id"]));
				echo '</td>';
			}
			else{
				echo '<td> </td>';
			}

				echo '<td>'.$value["created"].'</td>';
			}
			echo '</tr>';
		}
	echo '<div id="hidden_tag"></div>';
echo '</table>';
?>