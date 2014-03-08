


<div>
	<?php
		echo $this->Form->create('Ip');
		
			echo "<legend>";
			echo __('Them Ip moi');
			echo "</legend>";
			?>

				<?php echo $this->Form->input('ip', array('label'=>'Ip'));?>				

				<?php
			
		
		echo $this->Form->end(array('label'=>'Add'));
	?>
</div>


<table>
<tr>
	<th>ID</th>
	<th>IP</th>
	<th>User</th>
	<th>Edit</th>
	<th>Delete</th>
	
</tr>
<?php
	
	foreach ($datas as $data) {
   // var_dump($ip["Ip"]); die();
   
		echo '<tr>';
			echo '<td>'.$data["Ip"]["id"].'</td>';
			echo '<td>'.$data["Ip"]['ip'].'</td>';
           
            
			echo '<td>'.$data["User"]['username'].'</td>';
			
			echo '<td>';
			echo $this->Html->link('Edit', 
			array('controller'=>'manages','action' => 'editip',$data["Ip"]["id"]));
			echo '</td>';

			echo '<td>';
			echo $this->Html->link('Delete', 
				array('controller'=>'manages','action' => 'deleteip', $data["Ip"]["id"]));
			
			
			echo '</td>';
		echo '</tr>';
	}
?>
</table> 