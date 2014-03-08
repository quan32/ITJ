<h1></h1>
<?php
	echo $this->Form->create('Ip');
	echo $this->Form->input('ip', array('label' =>'Ip'));
	echo $this->Html->link('Cancel', array('action'=>'change'));
	echo $this->Form->end('Save');


?>