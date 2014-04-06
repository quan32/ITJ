<h1>買った講義の一覧を表示します。</h1>
<?php
$paginator = $this->Paginator;

if($registedLectures){

    echo "<table>";

        echo "<tr>";

            echo "<th>" . $paginator->sort('Lecture.id', '講義ID') . "</th>";
            echo "<th>" . $paginator->sort('Lecture.name', 'タイトル') . "</th>";
            echo "<th>" . $paginator->sort('Register.created', '登録の時間') . "</th>";
            echo "<th>コスト</th>";
            echo "<th>情報</th>";
            echo "</tr>";
        

        foreach( $registedLectures as $item ){

                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['Register']['created']."</td>";
                echo "<td>".$COST."VND</td>";
                echo "<td>".$this->Html->link('詳しく',array('controller' => 'Students','action' => 'detailLecture',$item['Lecture']['id'], 'registedLectures'));
                              
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