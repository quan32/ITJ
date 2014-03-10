<h1>統計表示</h1>
<?php
	echo '<table>
		<tr>
			<th>テスト数</th>
			<td>'.$countTest.'</td>
		</tr>
		<tr>
			<th>講義数名</th>
			<td>'.count($lectures).'</td>
		</tr>
		<tr>
			<th>勉強回数</th>
			<td>'.$countRegister.'</td>
		</tr>
		</table>';

echo "<button>".$this->Html->link('戻る', array('controller'=>'teachers','action'=>'info'))."</button>";

?>