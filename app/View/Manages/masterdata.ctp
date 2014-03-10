<h1>Thay đổi master data</h1>
<table>
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Value</th>
	<th>Edit</th>
</tr>
<?php
	//
	foreach ($cons as $con) {

        echo '<tr>';
			echo '<td>'.$con["Constant"]["id"].'</td>';
			echo '<td>'.$con["Constant"]['name'].'</td>';
           
            
			echo '<td>'.$con["Constant"]['value'].'</td>';
			
			echo '<td>';
			echo $this->Html->link('Edit', 
			array('controller'=>'manages','action' => 'editdata',$con["Constant"]["id"]));
			echo '</td>';

		echo '</tr>';
	}
?>
</table>