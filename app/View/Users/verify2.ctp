<div>
	<?php echo $this->Form->create('User'); ?>

	<fieldset>
		<legend>
			<h1>確認する質問：</h1>
		</legend>
		<?php echo $this->Form->input('question', array('label'=>'', 'options'=>$questions));?>
		<?php 
		echo $this->Form->input('verify', array('label'=>'答え：','type'=>'password'));
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label'=>'確認')); ?>
</div>
<?php
	echo $this->Html->link('答えを忘れた方', 
		array('controller' => 'manages', 'action' => 'info1'));
?>