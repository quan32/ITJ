<h1></h1>
<?php
	echo $this->Form->create('Ip');
	echo $this->Form->input('ip', array('label' =>'IP'));
	echo $this->Html->link('キャンセル', array('action'=>'change'));
	echo $this->Form->end('保存');


?>