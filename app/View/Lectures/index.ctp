
<?php
	// debug($lectures);die;
if($lectures != null)
{
	$paginator = $this->Paginator;
	echo'<h1>講義管理</h1><br />
		<table>
		<tr>';
	
		    echo "<th>" . $paginator->sort('Lecture.id', 'ID') . "</th>";
            echo "<th>" . $paginator->sort('Lecture.name', 'タイトル') . "</th>";
            echo "<th>" . $paginator->sort('Lecture.created', '作成時') . "</th>";
           
            echo '
			<th>テスト</th>
			<th>表現</th>
			<th>統計</th>
			<th>管理</th>
		</tr>';
	foreach ($lectures as $lecture) {
		echo '<tr>';
			echo '<td>'.$lecture['Lecture']["id"].'</td>';
			echo '<td>'.$lecture['Lecture']['name'].'</td>';
			echo '<td>'.$lecture['Lecture']['created'].'</td>';
			
			echo '<td>';
			echo $this->Html->link('リスト', 
				array('controller'=>'tests','action' => 'index',$lecture['Lecture']["id"]));
			echo '</td>';

			
			echo '<td>';
			echo $this->Html->link('表現', 
				array('controller'=>'lectures','action' => 'view',$lecture['Lecture']["id"]));
			echo '</td>';

			echo '<td>';
			echo $this->Html->link('見る', 
				array('action' => 'statisticsOfALecture',$lecture['Lecture']["id"],'index'));
			echo '</td>';

			echo '<td>';
			echo $this->Html->link('編集　', 
				array('action' => 'edit', $lecture['Lecture']["id"]));
			echo " ";
			echo $this->Form->postLink('　削除', 
				array('controller'=>'lectures','action' => 'delete',$lecture['Lecture']["id"]),
				array('confirm' => '本気？'));
			echo '</td>';
		echo '</tr>';
	}
	echo '</table> ';

	 echo "<div class='paging'>";

        echo $paginator->first("初");

        if($paginator->hasPrev()){
            echo $paginator->prev("前");
        }

        echo $paginator->numbers(array('modulus' => 2));

        if($paginator->hasNext()){
            echo $paginator->next("次");
        }

        echo $paginator->last("後");
        echo $this->Paginator->counter('ページ {:page} / {:pages}');
    
    echo "</div>";
}
else
{
	echo '<h1>空きデータ</h1>';
}
?>
