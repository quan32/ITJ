<div>
	<?php echo $this->Form->create('User'); ?>

	<fieldset>
		<legend>
			<?php echo __('<h1>Hay nhap ma xac nhan</h1>'); ?>
		</legend>
		<?php 
		echo $this->Form->input('verify', array('label'=>'verify code'));
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label'=>'Xac nhan')); ?>
</div>
<?php
	echo $this->Html->link('Ban mat ma xac nhan?', 
		array('controller' => 'managers', 'action' => 'info1'));
?>