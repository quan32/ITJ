<h1>基本情報変更</h1>
<?php
	echo $this->Form->create('User');
	echo $this->Form->input('fullname', array('label' =>'氏名'));
	echo $this->Form->input('date_of_birth', array('label' =>'誕生日'));
	echo $this->Form->input('sex', array('label'=>'性別', 'options'=>array('man'=>'男',
									'woman'=>'女')));
	echo $this->Form->input('address', array('label' => '住所'));

	echo $this->Form->input('mail', array('label' => 'メール'));
	echo $this->Form->input('mobile_No',array('label' => '電話番号' ));
	echo $this->Form->input('credit_card_No', array('label' => 'クレジットカード'));
	echo $this->Form->button('リセット', array('type' => 'reset'));
	echo $this->Html->link('キャンセル', array('action'=>'index'));
	echo $this->Form->end('セーブ');
	// echo $this->Form->button('Reset');
	// echo $this->Form->end('Submit');


?>