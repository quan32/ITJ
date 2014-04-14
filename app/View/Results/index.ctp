<?php
    App::import("Model", "User");
    $UserModel = new User();
?>
<h1>各テスト</h1><br />
<table>
<tr>
	<th>ID</th>
	<th>学生</th>
	<th>スコア</th>
	<th>時間</th>
	<th>表示</th>
</tr>
<?php
	foreach ($results as $result) {
		echo '<tr>';
		//foreach ($test['Test'] as $value) {
			//var_dump($test);die;
		$value = $result['Result'];
			echo '<td>'.$value["id"].'</td>';
			echo '<td>'.$UserModel->username($value["user_id"]).'</td>';
			echo '<td>'.$value["score"].'</td>';			
			echo '<td>'.$value["created"].'</td>';
			echo '<td>'.$this->Html->link('見る', 
				array('controller'=> 'results', 'action' => 'view', $value["id"]));
		//}
		echo '</tr>';
	}
?>
</table>