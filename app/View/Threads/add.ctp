<h1>Add Thread</h1>
<?php
	echo $this->Form->create('Thread');
	echo $this->Form->input('title', array('rows' => '1'));
	echo $this->Form->input('description', array('rows' => '5'));
	echo $this->Form->end('Add thread');

?>