<div>
	<?php echo $this->Form->create('Test', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('新しテストを作成'); ?></legend>
		<?php
		echo $this->Form->input('name', array('label'=>'タイトル'));
		echo $this->Form->input('time', array('label'=>'テスト時間'));
		echo $this->Form->input('tsv_file',array( 'type' => 'file'));
		/*
		echo $this->Form->input('user_id');
		echo $this->Form->input('file_id');*/
		?>
	</fieldset>

	<?php echo $this->Form->end(array('label'=>'作成')); ?>
</div>
