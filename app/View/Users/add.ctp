<div>
	<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Register New User'); ?></legend>
		<?php 
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('role',
			array('options'=>array('student'=>'Student',
				'teacher'=>'Teacher', 'admin'=>'Admin')));
		?>
	</fieldset>

	<?php echo $this->Form->end(array('label'=>'Add user')); ?>
</div>
