<h1>確認するコード変更</h1>
<?php
	echo $this->Form->create('User');
	// echo $this->Form->input('currVerify', array('label' =>'現在確認するコード '));
	echo $this->Form->input('currQuestion', array('label'=>'', 'options'=>$questions));
	echo $this->Form->input('currVerify', array('label'=>'答え：','type'=>'password'));
	// echo $this->Form->input('newVerify', array('label' =>'新しい確認するコード '));
	// echo $this->Form->input('confVerify',array('label' => '確認するの'));
	echo $this->Form->input('newQuestion', array('label'=>'', 'options'=>$questions));
	echo $this->Form->input('newVerify', array('label'=>'答え：','type'=>'password'));
	echo $this->Form->input('confVerify', array('label'=>'確認：','type'=>'password'));
	echo $this->Form->end('変更');
?>

<?php
	echo $this->Html->link('答えを忘れた方', 
		array('controller' => 'manages', 'action' => 'info1'));
?>