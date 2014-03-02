<div>
	<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __("資格を選んでください"); ?></legend>
		<?php 
		echo $this->Form->input('role',
			array('label'=>'資格',
				'options'=>array('student'=>'学生',
				'teacher'=>'先生')));
		?>
	</fieldset>

	<?php echo $this->Form->end(array('label'=>'次へ')); ?>
</div>