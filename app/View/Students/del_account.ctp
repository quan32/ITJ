<?php
	echo $this->Form->create('Del_account');
	echo 'アカウントを無効にすると、全部にユーザーの関係情報が削除されます。';
	echo $this->Html->link('キャンセル', array('action'=>'index'));
	echo $this->Form->end('承認');

?>