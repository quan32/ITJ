<h1>１週間以内、買った講義の一覧を表示します。</h1>
<?php
$paginator = $this->Paginator;

if($registedLectureThisWeek){

    echo "<table>";

        echo "<tr>";

            echo "<th>" . $paginator->sort('Lecture.id', '講義ID') . "</th>";
            echo "<th>" . $paginator->sort('Lecture.name', 'タイトル') . "</th>";
            echo "<th>" . $paginator->sort('Register.created', '登録の時間') . "</th>";
            echo "<th>コスト</th>";
            echo "<th>情報</th>";
            echo "<th> 勉強 </th>";
            echo "<th> テスト </th>";
            echo "<th> 結果 </th>";
            echo "</tr>";
        

        foreach( $registedLectureThisWeek as $item ){

                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['Register']['created']."</td>";
                echo "<td>".$cost."</td>";
                echo "<td>".$this->Html->link('詳しく',array('controller' => 'lectures','action' => 'detail',$item['Lecture']['id'], 'registedLectureThisWeek'));
       

            if($item['Block'] == 1)
            {
                echo "<td>ブロック</td>";
                echo "<td>ブロック</td>";
                echo "<td>ブロック</td>"; 
            }
            else
            {
                if($item['Register']['status'] == 0)
                    echo "<td>".$this->Html->link("受講",array("controller" => "lectures", "action" => "view",$item['Lecture']['id']))."</td>";
                else
                    if($item['Register']['status'] == 1)
                    echo "<td>".$this->Html->link("もう一度",array("controller" => "lectures", "action" => "view",$item['Lecture']['id']))."</td>";
                    else echo "なし";

                if($item['StatusTest'] == 0)
                     
                    {
                        echo "<td>なし</td>";
                        echo "<td>なし</td>";
                    }

                 else if($item['StatusTest'] == 1)
                        {
                            echo "<td>".$this->Html->link('受ける',array('controller' => 'tests','action' => 'view',$item['Lecture']['id'], ))."</td>";
                            echo "<td>なし</td>";
                        }
                        else if($item['StatusTest'] ==2 )
                        {
                            echo "<td>".$this->Html->link('もう一度',array('controller' => 'tests','action' => 'view',$item['Register']['id'], ))."</td>";
                            echo "<td>".$this->Html->link('レビュー',array('controller' => 'results','action' => 'view',$item['Register']['id']))."</td>";
                        }
                        else echo "<td>なし</td>";


            }
            
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