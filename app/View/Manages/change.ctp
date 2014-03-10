<h2>Add New IP</h2>
<div>
		<?php echo $this->Form->create('Ip');?>
		<?php echo $this->Form->input('ip');?>		

		<?php echo $this->Form->end(array('label'=>'Add'));	?>
</div>
<hr>
<h2><?php echo __('Acceptable IP List'); ?></h2>
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