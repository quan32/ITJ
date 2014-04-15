<?php
	if($reported == 1) {
		echo "<h3>レポートしました</h3><br>";
		
		}
	if($reported == 0) {
			echo "<h3>エラーがあります。も一度お願いします。</h3><br>";
			//echo "<td>".$this->Html->link('ホームページ |',array('controller' => 'Teachers','action' => 'index'),array('class'=>'link_buttonx'));
			echo "<td>".$this->Html->link(' レポート',array('controller' => 'Reports','action' => 'report',$lec_id),array('class'=>'link_buttonx'));
			}
	if($reported == 2) {
			echo "<h3>あなたは前にこの講義をレポートしました。</h3><br>";
	}
	if($menu_type == 'teacher_menu'){
		echo "<td>".$this->Html->link('ホームページ',array('controller' => 'Teachers','action' => 'index'),array('class'=>'link_buttonx'));
		}else {echo "<td>".$this->Html->link('ホームページ',array('controller' => 'Students','action' => 'index'),array('class'=>'link_buttonx'));}
?>