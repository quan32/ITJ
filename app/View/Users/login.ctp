<div>
	<?php echo $this->Session->flash('auth'); ?>
	<?php echo $this->Form->create('User'); ?>

	<fieldset>
		<legend>
			<?php echo __('<h1>Please enter your username and password</h1>'); ?>
		</legend>
		<?php echo $this->Form->input('username');
		echo $this->Form->input('password');
		?>
	</fieldset>
	<?php echo $this->Form->end(array('Send Post')); ?>
</div>
<?php
	echo $this->Html->link('Add user', 
		array('controller' => 'users', 'action' => 'add'));
?>