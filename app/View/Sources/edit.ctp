<table>
<tr>
	<th>ID</th>
	<th>タイトル</th>
	<th>管理</th>
</tr>
<legend>アップロードしたファイル:</legend>
<?php
	foreach ($sources as $source) {
		echo '<tr>';
		echo '<td>'.$source["Source"]["id"].'</td>';
		echo '<td>'.$source["Source"]["filename"].'</td>';
		echo '<td>';
		echo $this->Form->postLink('削除', array('controller'=>'sources', 'action'=>'delete', 
			$source["Source"]["id"]), array('confirm'=>'本気？'));
		echo '</td>';
		echo '</tr>';
	}
?>
</table> 
<br><br>

<fieldset>
	<legend>新ファイルを選んで:</legend>

	<?php 
		echo $this->Form->create('Source', array('type'=>'file'));
	?>

	<?php if (!empty($this->data['Source']['filepath'])): ?>
		<div class="input">
			<label>アップロードしたファイル</label>
			<?php
			echo $this->Form->input('filepath', array('type'=>'hidden'));
			echo $this->Html->link(basename($this->data['Source']['filepath']), $this->data['Source']['filepath']);
			?>
		</div>
	<?php else: ?>
		<?php echo $this->Form->input('filename',array(
			'type' => 'file'
		)); ?>
	<?php endif; ?>

	<?php
		echo $this->Form->end('アップロード');
		echo "<button onclick='window.history.back();' class='link_buttonx'>戻る</button>";
		echo $this->Html->link('完成', array('controller'=>'teachers', 'action'=>'index'), array('class'=>'link_buttonx'));
	?>
</fieldset>

<style type="text/css">
	button{
		height:auto;
	}
	legend{
		color:red!important;
		font-weight: bold;
	}
</style>