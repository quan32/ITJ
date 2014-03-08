<fieldset>
	<legend>Them file vao bai giang</legend>

	<?php 
		echo $this->Form->create('Source', array('type'=>'file','enctype'=>'multipart/form-data'));
		echo $this->Form->input('file',array('type' => 'file'));
		echo $this->Form->end('Upload');
	?>
</fieldset>