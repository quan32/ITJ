<h3>レポートの確認</h3></br>

<?php
if($reported != 0) {
	echo "<h3>あなたは前にこの講義をレポートしました。</h3><br>";
	if($menu_type == 'teacher_menu'){
		echo "<td>".$this->Html->link('ホームページ',array('controller' => 'Teachers','action' => 'index'),array('class'=>'link_buttonx'));
		}else {echo "<td>".$this->Html->link('ホームページ',array('controller' => 'Students','action' => 'index'),array('class'=>'link_buttonx'));}
	}else {
	echo "<h3>レポート機能は各講義に著作権侵害の問題がある場合のためです。あなたはこの講義をほんとにレポートしたいですか？　<br></h3>";
	
	echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
	echo "<th>講義のタイトル</th>";
	echo "<th>作者</th>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>".$lec_id."</th>";
	echo "<th>".$lec_name."</th>";
	echo "<th>".$author."</th>";
	echo "</tr>";
	echo "</table>";
	if($menu_type == 'teacher_menu') {
			echo "<td>".$this->Html->link('キャンセル |',array('controller' => 'Teachers','action' => 'index'),array('class'=>'link_buttonx'));
			}else {echo "<td>".$this->Html->link('キャンセル',array('controller' => 'Students','action' => 'index'),array('class'=>'link_buttonx'));}
			echo "<td>".$this->Html->link(' レポート',array('controller' => 'Reports','action' => 'report',$lec_id),array('class'=>'link_buttonx'));
	}
?>			