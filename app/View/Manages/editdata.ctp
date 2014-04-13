
<?php
    
	echo $this->Form->create('Constant');
	echo $this->Form->label($data[0]["Constant"]["name"]);
	echo $this->Form->input('value', array('label' =>'価値','value'=>$data[0]["Constant"]["value"]));	
	echo $this->Html->link('キャンセル', array('action'=>'masterdata'));
	echo $this->Form->end('保存');


?>