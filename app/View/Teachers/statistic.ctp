<h1>統計表示</h1>
<?php
	echo '<table>
		<tr>
			<td>テスト数</td>
			<td>'.count($tests).'</td>
		</tr>
		<tr>
			<td>講義数名</td>
			<td>'.count($lectures).'</td>
		</tr>
		<tr>
			<td>勉強回数</td>
			<td>'.$countRegister.'</td>
		</tr>'
		;

echo $this->Html->link('戻る', array('controller'=>'teachers','action'=>'info'));

?>