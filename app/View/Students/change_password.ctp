<h1>パスワード変更</h1>
<?php
	echo $this->Form->create('User');
	echo $this->Form->input('currPassword', array('label' =>'古いパスワード ','type' => 'password'));
	echo $this->Form->input('newPassword', array('label' =>'新しいパスワード ','type' => 'password'));
	echo $this->Form->input('confPassword',array('label' => '確認する 
パスワード','type' => 'password'));
	echo $this->Html->link('Cancel', array('action'=>'info'));
	echo $this->Form->end('変更');
?>