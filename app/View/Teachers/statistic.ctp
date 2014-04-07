<h1>統計表示</h1><br />
<?php
	echo '<table>
		<tr>
			<td>テスト数</td>
			<td>'.$countTest.'</td>
		</tr>
		<tr>
			<td>講義数名</td>
			<td>'.count($lectures).'</td>
		</tr>
		<tr>
			<td>勉強回数</td>
			<td>'.$countRegister.'</td>
		</tr>
		</table>';

echo "<button class = ".'"link_buttonx"'.">".$this->Html->link('戻る', array('controller'=>'teachers','action'=>'info'))."</button>";

?>

<style type="text/css">
    button{
        height:37px;
    }
</style>