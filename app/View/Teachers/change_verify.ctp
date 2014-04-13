<h1>確認するコード変更</h1>
<?php
	echo $this->Form->create('User');
	echo $this->Form->input('currVerify', array('label' =>'現在確認するコード ','type' => 'password'));
	echo $this->Form->input('newVerify', array('label' =>'新しい確認するコード ','type' => 'password'));
	echo $this->Form->input('confVerify',array('label' => '確認するの','type' => 'password'));
	// echo $this->Html->link('Cancel', array('controller'=>'users','action'=>'info'));
	echo $this->Form->end('変更');
?>