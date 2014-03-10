<div>
	<?php echo $this->Form->create('User'); ?>

	<fieldset>
		<legend>
			<?php echo __('<h1>確認コードを入力してください</h1>'); ?>
		</legend>
		<?php 
		echo $this->Form->input('verify', array('label'=>'verify code'));
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label'=>'確認')); ?>
</div>
<?php
	echo $this->Html->link('確認コードを忘れた方', 
		array('controller' => 'manages', 'action' => 'info1'));
?>