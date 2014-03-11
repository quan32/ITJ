<fieldset>
	<legend>Verifyコードが忘れていた場合</legend>
	<h1>このメールアドレスに連絡してください</h1>
	<h2>メールアドレス:admin123@gmail.com</h2>
	<h2>内容:</h2>
	<h3>blah blah</h3>
</fieldset>
<?php
	echo $this->Html->link('戻る', 
		array('controller' => 'users', 'action' => 'login'));
?>