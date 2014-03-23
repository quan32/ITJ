<fieldset>
	<legend>パスワードを忘れた場合</legend>
	<h3>初期のパスワードにリセットするため、このメールを通じて、管理者に連絡してください</h3>
	<h3>メールアドレス:admin123@gmail.com</h3>
	<h3>内容:</h3>
	<h3>パスワードを忘れてしまいました。初期のパスワードにリセットしていただけないでしょうか。</h3>
</fieldset>
<?php
	echo $this->Html->link('戻る', 
		array('controller' => 'users', 'action' => 'login'));
?>