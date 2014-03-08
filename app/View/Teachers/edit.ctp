<h1>基本情報変更</h1>
<?php
	echo $this->Form->create('User');
	echo $this->Form->input('fullname', array('label' =>'氏名'));
	echo $this->Form->input('date_of_birth', array('label' =>'誕生日'));
	echo $this->Form->input('mobile_No',array('label' => '電話番号' ));
	echo $this->Form->input('address', array('label' => 'アドレス'));

	echo $this->Form->button('Reset', array('type' => 'reset'));
	echo $this->Html->link('Cancel', array('action'=>'index'));
	echo $this->Form->end('Save');
	// echo $this->Form->button('Reset');
	// echo $this->Form->end('Submit');


?>