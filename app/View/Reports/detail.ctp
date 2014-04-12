<h1>レポート管理 (詳しく)</h1><br />
<?php
echo "<table>";
    echo "<tr>";
    echo "<th>講義ID</th>";
	echo "<th>講義のタイトル</th>";
	echo "<th>作者</th>";
	echo "<th>レポート者</th>";
	echo "<th>講義を表現</th>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>".$lecture['id']."</th>";
	echo "<th>".$lecture['name']."</th>";
	echo "<th>".$lecture_author."</th>";
	echo "<th>".$reporter."</th>";
	echo "<th>".$this->Html->link('表現', array('controller'=>'lectures','action' => 'view', $lecture['id']))."</th>";
	echo "</tr>";
	echo "</table>";

	echo "<td>".$this->Html->link('戻る　 |',array('controller' => 'Reports','action' => 'viewreports'));
	echo "<td>".$this->Html->link('　　反対　 |',array('controller' => 'Reports','action' => 'delreport',$rep_id));
	if($rep_status == 1) echo "<td>".$this->Html->link(' 　賛成',array('controller' => 'Reports','action' => 'reported',$rep_id));
	?>