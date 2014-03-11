<fieldset>
	<legend>講義の添付ファイルを選択してください</legend>

	<?php 
		echo $this->Form->create('Source', array('type'=>'file','enctype'=>'multipart/form-data'));
	?>

		 <?php if (!empty($this->data['Source']['filepath'])): ?>
			<div class="input">
			<label>添削したファイル</label>
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
		echo $this->Form->end('Upload');
		echo "<button onclick='window.history.back();'>戻る</button>";
		echo $this->Html->link('｜　完成', array('controller'=>'lectures', 'action'=>'index'));
	?>
</fieldset>