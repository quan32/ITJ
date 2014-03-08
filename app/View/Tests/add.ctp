<div>
	<?php echo $this->Form->create('Test', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Add New Test'); ?></legend>
		<?php
		echo $this->Form->input('name');
		echo $this->Form->input('time');
		echo $this->Form->input('tsv_file',array( 'type' => 'file'));
		/*
		echo $this->Form->input('user_id');
		echo $this->Form->input('file_id');*/
		?>
	</fieldset>

	<?php echo $this->Form->end(array('label'=>'Add Test')); ?>
</div>
