<fieldset>
	<legend>Them file vao bai giang</legend>

	<?php 
		echo $this->Form->create('Source', array('type'=>'file','enctype'=>'multipart/form-data'));
	?>

		 <?php if (!empty($this->data['Source']['filepath'])): ?>
			<div class="input">
			<label>Uploaded File</label>
			<?php
			echo $this->Form->input('filepath', array('type'=>'hidden'));
			echo $this->Html->link(basename($this->data['Source']['filepath']), $this->data['Source']['filepath']);
			?>
		</div> 
	<?php else: ?>
		<?php echo $this->Form->input('filename',array(
			'type' => 'file'
		)); ?>
		 <?php endif; ?> 

	<?php
		echo $this->Form->end('Upload');
		echo "<button onclick='window.history.back();'>Back</button>";
		echo $this->Html->link('Finish', array('controller'=>'lectures', 'action'=>'index'));
	?>
</fieldset>