<h2>新しいIPアドレス追加</h2>
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
	<th>ユーザー</th>
	<th>編集</th>
	<th>削除</th>
	
</tr>
<?php
	
	foreach ($datas as $data) {
   // var_dump($ip["Ip"]); die();
   
		echo '<tr>';
			echo '<td>'.$data["Ip"]["id"].'</td>';
			echo '<td>'.$data["Ip"]['ip'].'</td>';
           
            
			echo '<td>'.$data["User"]['username'].'</td>';
			
			echo '<td>';
			echo $this->Html->link('変更', 
			array('controller'=>'manages','action' => 'editip',$data["Ip"]["id"]));
			echo '</td>';

			echo '<td>';
			echo $this->Html->link('削除', 
				array('controller'=>'manages','action' => 'deleteip', $data["Ip"]["id"]));
			
			
			echo '</td>';
		echo '</tr>';
	}
?>
</table> 