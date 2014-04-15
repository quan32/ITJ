<h1>各メッセージの表現</h1><br />
<?php
 echo "<h3>あなたは全部　".count($message_data)." メッセージがあります！</h3>";
 if(count($message_data) > 0){
	 echo "<table>";
	 echo "<tr>";
		echo "<th>メッセージID</th>";
		echo "<th>もらった時間</th>";
		echo "<th>内容</th>";
		echo "<th>詳しく</th>";
		echo "<th>削除</th>";
		echo "</tr>";
		foreach($message_data as $data) {
			echo "<tr>";
			echo "<th>".$data['Message']['id']."</th>";
			echo "<th>".$data['Message']['created']."</th>";
			echo "<th>".substr($data['Message']['content'],0,72)."...</th>";
			echo "<th>".$this->Html->link('表現', array('controller'=>'Messages','action' => 'detail', $data['Message']['id'],$data['Message']['lecture_id']))."</th>";
			echo "<th>".$this->Html->link('削除',array('controller'=>'Messages','action' => 'delete', $data['Message']['id']))."</th>";
			echo "</tr>";
		}
	 echo "</table>";
 }
 if($menu_type == 'teacher_menu'){
		echo "<td>".$this->Html->link('ホームページ',array('controller' => 'Teachers','action' => 'index'),array('class'=>'link_buttonx'));
		}else {echo "<td>".$this->Html->link('ホームページ',array('controller' => 'Students','action' => 'index'),array('class'=>'link_buttonx'));}
?>