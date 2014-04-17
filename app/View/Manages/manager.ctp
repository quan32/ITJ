<h1>管理者管理</h1>
<?php
$paginator = $this->Paginator;
    echo "<table>";

        echo "<tr align='center'>";

            echo "<th>" . $paginator->sort('User.username', 'ユーザ名') . "</th>";
            echo "<th>" . $paginator->sort('User.username', '氏名') . "</th>";
            echo "<th>" . $paginator->sort('User.role', '資格') . "</th>";
            echo "<th>詳細</th>";
            echo "<th>情報変更</th>";
            echo "<th>Ip変更</th>";
            echo "<th>管理</th>";

        echo "</tr>";
       // debug($users); die();
  	    
	
	foreach ($users as $user) {
		if (!in_array($user["User"]["state"], array('deleted','locked'))){

		echo '<tr>';
			echo '<td>'.$user["User"]["username"].'</td>';
			echo '<td>'.$user["User"]["fullname"].'</td>';
			echo '<td>'.$user["User"]["role"].'</td>';
			
            echo '<td>';
            echo $this->Html->link('詳細', 
                array('controller'=>'manages','action' => 'detail', $user["User"]["id"]));
            echo '</td>'; 
            echo '<td>';
            echo $this->Html->link('変更', 
                array('controller'=>'manages','action' => 'editinfo', $user["User"]["id"]));
            echo '</td>'; 
             echo '<td>';
            echo $this->Html->link('Ip変更', 
                array('controller'=>'manages','action' => 'adminip', $user["User"]["id"]));
            echo '</td>';           			    
	    echo '<td>';
       
        echo $this->Form->postLink('削除', 
				array('controller'=>'users','action' => 'delete', $user["User"]["id"]),
				array('confirm'=>'本気？'));
            
			
		echo "</td>";    

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