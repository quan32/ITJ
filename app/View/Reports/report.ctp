<?php
	if($reported == 1) {
		echo "<h3>レポートしました</h3><br>";
		
		}
	if($reported == 0) {
			echo "<h3>エラーがあります。も一度お願いします。</h3><br>";
			//echo "<td>".$this->Html->link('ホームページ |',array('controller' => 'Teachers','action' => 'index'));
			echo "<td>".$this->Html->link(' レポート',array('controller' => 'Reports','action' => 'report',$lec_id));
			}
	if($reported == 2) {
			echo "<h3>あなたは前にこの講義をレポートしました。</h3><br>";
	}
	echo "<td>".$this->Html->link('ホームページ',array('controller' => 'Teachers','action' => 'index'));
?>