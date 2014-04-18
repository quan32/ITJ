<h1>基本情報変更</h1>
<?php

	echo $this->Form->create('User');
	echo $this->Form->input('id', array('label' =>'','type'=>'hidden'));
	echo $this->Form->input('role', array('label' =>'','type'=>'hidden'));
	echo $this->Form->input('fullname', array('label' =>'氏名'));
	echo $this->Form->input('date_of_birth', array('label' =>'誕生日'));
	echo $this->Form->input('sex', array('label'=>'性別', 'options'=>array('man'=>'男',
									'woman'=>'女')));
	echo $this->Form->input('address', array('label' => '住所'));

	echo $this->Form->input('mail', array('label' => 'メール'));
	echo $this->Form->input('mobile_No',array('label' => '電話番号' ));
	if ($this->Form->data['User']['role']=='student') {
		echo $this->Form->input('credit_card_No', array('label' => 'クレジットカード情報'));
	}
	else
	echo $this->Form->input('bank_acc', array('label' => '銀行口座'));

	echo $this->Form->button('リセット', array('type' => 'reset'));
	if ($this->Form->data['User']['role']=='manager') {
	echo $this->Html->link('キャンセル', array('action'=>'manager'), array('class'=>'link_buttonx'));
	}
	else echo $this->Html->link('キャンセル', array('action'=>'accept'), array('class'=>'link_buttonx'));
	

	echo $this->Form->end('変更');

	// echo $this->Form->button('Reset');
	// echo $this->Form->end('Submit');


?>

<style type="text/css">
	button{
		height: 37px;
		padding-left:10px;
		padding-right: 10px;
		color:#fff;
		border:1px!important;
		border-radius:4px;
	}
</style>