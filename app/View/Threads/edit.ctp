
<h1>Edit Thread</h1>
<?php
	echo $this->Form->create('Thread');
	echo $this->Form->input('title', array('rows' => '2'));
	echo $this->Form->input('description', array('rows' => '4'));
	echo $this->Form->input('id', array('type' => 'hidden'));
	echo $this->Form->end('Save Changes');

?>