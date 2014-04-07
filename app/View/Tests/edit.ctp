<div>
	<?php echo $this->Form->create('Test', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('テスト編集'); ?></legend>
		<?php
		echo $this->Form->input('name', array('label'=>'タイトル'));
		echo $this->Form->input('time', array('label'=>'テスト時間'));
		echo $this->Form->input('tsv_file',array( 'type' => 'file'));
		?>
	</fieldset>

	<?php echo $this->Form->end(array('label'=>'更新')); ?>
</div>
