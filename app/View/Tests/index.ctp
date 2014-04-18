<h1>各テスト</h1><br />
<table>
<tr>
	<th>ID</th>
	<th>タイトル</th>
	<th>テスト時間</th>
	<th>講義の ID</th>
	<th>作った時間</th>
	<?php if($user_role=="teacher" || $user_role=="manager"): ?>
		<th>管理</th>
	<? endif; ?>
</tr>
<?php
	foreach ($tests as $test) {
		echo '<tr>';
		//foreach ($test['Test'] as $value) {
			//var_dump($test);die;
		$value = $test['Test'];
			if($value['state'] == "normal"){
		            			

							echo '<td>'.$value["id"].'</td>';
							echo '<td>'.$this->Html->link($value['name'],
								array('action' => 'view',$value['id'])).'</td>';
							echo '<td>'.$value["time"].'</td>';
							echo '<td>'.$value["lecture_id"].'</td>';			
							echo '<td>'.$value["created"].'</td>';
							



						if($user_role=='manager'){
	            			echo "<td><div class='source_block'>";
	            			echo $this->Html->link('ブロック  ', array('action'=>'block', $value['id']));
	            			echo $this->Html->link('削除', array('action'=>'delete', $value['id']));
	            			echo "</div></td>";
            			}elseif($user_role=='teacher'){
					        echo '<td>'.$this->Html->link('編集', 
								array('action' => 'edit', $value["id"]));
							echo " | ";
							echo $this->Form->postLink('削除', 
								array('action' => 'delete', $value["id"]),
								array('confirm' => '本気？'));
							echo " | ";
							echo $this->Html->link('結果', 
								array('controller'=>'results','action' => 'index', $value["id"]));
							echo '</td>';
            			}




            		}elseif($value['state'] == "blocked"){
            			if($user_role=='manager'){
            				echo '<td>'.$value["id"].'</td>';
							echo '<td>'.$this->Html->link($value['name'],
								array('action' => 'view',$value['id'])).'</td>';
							echo '<td>'.$value["time"].'</td>';
							echo '<td>'.$value["lecture_id"].'</td>';			
							echo '<td>'.$value["created"].'</td>';
							

            				echo "<td><div class='source_block'>";
	            			echo $this->Html->link('アンチブロック  ', array('action'=>'unblock', $value['id']));
	            			echo $this->Html->link('削除', array('action'=>'delete', $value['id']));
	            			echo "</div></td>";
            			}elseif($user_role=='teacher'){
            				echo "<td><span class='test_block_error'>このテストは管理者によってブロックさせられた。</span></td>";
            			}else{
            				echo "<td><span class='test_block_error'>このテストは管理者によってブロックさせられた。</span></td>";
            			}

            		}
		//}
		echo '</tr>';
	}
?>
</table>
<br /><br />
<?	
	if($user_role=="teacher")
		echo $this->Html->link('新しいテストを作成',
					array('controller' => 'tests','action' => 'add',$lecture_id)); 
?>

<style type="text/css">
	.test_block_error{
		color:red;
	}
</style>