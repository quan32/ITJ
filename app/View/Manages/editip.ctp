<h1></h1>
<?php
	echo $this->Form->create('Ip');
	echo $this->Form->input('ip', array('label' =>'IP'));
	if ($this->Form->data['Ip']['user_id']==$current_user) 
	echo $this->Html->link('キャンセル', array('action'=>'change'));
    else
	echo $this->Html->link('キャンセル', array('action'=>'adminip',$this->Form->data['Ip']['user_id']));
    
	echo $this->Form->end('保存');


?>