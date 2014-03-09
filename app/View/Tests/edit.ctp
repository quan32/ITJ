<div>
	<?php echo $this->Form->create('Test', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Edit Test'); ?></legend>
		<?php
		echo $this->Form->input('name');
		echo $this->Form->input('time');
		echo $this->Form->input('tsv_file',array( 'type' => 'file'));
		?>
	</fieldset>

	<?php echo $this->Form->end(array('label'=>'Update Test')); ?>
</div>
