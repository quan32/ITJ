<?php
if(!empty($data)){
	echo '<table>
		<tr>
			<td>テスト名</td>
			<td>学生名</td>
			<td>タイム</td>
			<td>結果</td>
		</tr>';
	foreach ($data as $item) {
		echo '<tr>';
		echo '<td>'.$item['testName'].'</td>';
		echo '<td>'.$item['studName'].'</td>';
		echo '<td>'.$item['time'].'</td>';
		echo '<td>'.$item['score'].'</td>';
		echo '</tr>';
	}
}
else{
	echo 'test result empty';
}

echo $this->Html->link('戻る', array('controller'=>'teachers','action'=>'info'));

?>