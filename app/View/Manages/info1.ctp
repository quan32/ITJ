<fieldset>
	<legend>VerifyCodeを忘れた場合</legend>
	<h3>初期のVerifyCodeにリセットするため,<br />
	以下のメールで管理者に連絡してください</h3><br />

	<table>
		<tr>
			<td>宛先</td>
			<td>:admin123@gmail.com</td>
		<tr>
		<tr>
			<td>ユーザ名</td>
			<td>:...</td>
		<tr>
		<tr>
			<td>電話番号</td>
			<td>:...</td>
		<tr>
		<tr>
			<td>内容</td>
			<td>:VerifyCodeを忘れてしまいました。初期のVerifyCodeにリセットしていただけないでしょうか。</td>
		<tr>
	</table>
</fieldset>
<?php
	echo $this->Html->link('戻る', 
		array('controller' => 'users', 'action' => 'login'), array('class'=>'link_buttonx'));
?>

<style type="text/css">
	table{
		border:1px solid #4c66a4!important;
		margin-top:10px;
		margin-bottom: 20px!important;
	}
</style>