<h1></h1>
<?php
    
	echo $this->Form->create('Constant');
	echo $this->Form->label($data[0]["Constant"]["name"]);
	echo $this->Form->input('value', array('label' =>'value','value'=>$data[0]["Constant"]["value"]));	
	echo $this->Html->link('Cancel', array('action'=>'masterdata'));
	echo $this->Form->end('Save');


?>