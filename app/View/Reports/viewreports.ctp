<h1>レポート管理</h1><br />
<?php
$paginator = $this->Paginator;

if($reportsdata){
	//debug($reportsdata); die;
    echo "<table>";

        echo "<tr>";

            echo "<th>" . $paginator->sort('Report.lecture_id', '講義ID') . "</th>";
            echo "<th>" . $paginator->sort('Report.user_id', 'レポート者ID') . "</th>";
            echo "<th>" . $paginator->sort('Report.created', 'レポート時間') . "</th>";
			echo "<th>". $paginator->sort('Report.status','状態')."</th>";
            echo "<th>情報</th>";
            echo "</tr>";
        

        foreach( $reportsdata as $item ){

                echo "<tr>";
                echo "<td>".$item['Report']['lecture_id']."</td>";
                echo "<td>".$item['Report']['user_id']."</td>";
                echo "<td>".$item['Report']['created']."</td>";
				if($item['Report']['status'] == 2) {echo "<td>賛成しました</td>";} else {echo "<td>まだ</td>";}
                echo "<td>".$this->Html->link('詳しく',array('controller' => 'Reports','action' => 'detail',$item['Report']['id'], $item['Report']['lecture_id'],$item['Report']['user_id'],$item['Report']['status']));
                              
                echo "</tr>";
        }
        
    echo "</table>";

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
    
}

else{
    echo " 空きデータ";
}


?>