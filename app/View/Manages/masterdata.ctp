<table>
<tr>
	<th>ID</th>
	<th>タイトル</th>
	<th>価値</th>
	<th>編集</th>
</tr>
<?php
	//
	foreach ($cons as $con) {

        echo '<tr>';
			echo '<td>'.$con["Constant"]["id"].'</td>';
			echo '<td>'.$con["Constant"]['name'].'</td>';
           
            
			echo '<td>'.$con["Constant"]['value'].'</td>';
			
			echo '<td>';
			echo $this->Html->link('編集', 
			array('controller'=>'manages','action' => 'editdata',$con["Constant"]["id"]));
			echo '</td>';

		echo '</tr>';
	}
?>
</table>