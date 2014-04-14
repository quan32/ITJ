<h1>講義管理</h1><br />


<?php
$paginator = $this->Paginator;
    echo "<table>";

        echo "<tr align='center'>";

            echo "<th>" . $paginator->sort('Lecture.id', 'ID') . "</th>";
            echo "<th>" . $paginator->sort('Lecture.name', 'タイトル') . "</th>";
            echo "<th>" . $paginator->sort('User.username', 'ユーザー名') . "</th>";
            echo "<th>作成した日時</th>";
            echo "<th>更新日時</th>";
            echo "<th> 詳細</th>";
            echo "<th>管理</h1>";

        echo "</tr>";
        foreach ($lectures as $lecture) {

   if (!in_array($lecture["User1"]["state"], array('deleted','locked'))) {
   		echo '<tr>';
			echo '<td>'.$lecture["Lecture"]["id"].'</td>';
			echo '<td>'.$lecture["Lecture"]['name'].'</td>';
           
            
			echo '<td>'.$lecture["User1"]['username'].'</td>';
			echo '<td>'.$lecture["Lecture"]['created'].'</td>';
			echo '<td>'.$lecture["Lecture"]['modified'].'</td>';

			echo '<td>';
			echo $this->Html->link('表現', 
			array('controller'=>'lectures','action' => 'view', $lecture["Lecture"]["id"]));
			echo '</td>';

			echo '<td>';
			echo $this->Form->postLink('削除', 
				array('controller'=>'manages','action' => 'delete_lec', $lecture["Lecture"]["id"]),
				array('confirm'=>'本気？'));
			
			
			echo '</td>';
		echo '</tr>';
	

   }
	}
?>
</table> 
<?php
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
    
    echo "</div>";
?>