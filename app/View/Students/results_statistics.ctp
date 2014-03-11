<h1>テスト結果</h1>
<?php
$paginator = $this->Paginator;
if($results)
{
    echo "<table>";

        echo "<tr>";

            echo "<th>" . $paginator->sort('id', 'ID') . "</th>";
            echo "<th>" . $paginator->sort('name', 'タイトル') . "</th>";
            echo "<th>" . $paginator->sort('created', '時間') . "</th>";
            echo "<th>" . $paginator->sort("score", 'コスト') . "</th>";
            echo "<th>講義の説明</th>
                <th>テストの操作</th>
                <th>結果の操作</th>";

        echo "</tr>";


        foreach( $results as $item ){

                echo "<tr>";
                echo "<td>".$item['Result']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['Result']['created']."</td>";
                echo "<td>".$item['Result']['score']."</td>";
                echo "<td>".$this->Html->link('詳しく',array('controller' => 'lectures','action' => 'detail',$item['Lecture']['id'], 'result_statistics'));
                if($item['Block'] == 1){
                    echo "<td>ブロック</td>";
                    echo "<td>ブロック</td>";
                }
                else{        
                        $lastWeek = time() - 7*24*60*60;

                      if(strtotime($item['Register']['created']) >= $lastWeek)
                        {
                            echo "<td>".$this->Html->link('もう一度テスト',array('controller' => 'tests','action' => 'view',$item['Test']['id'], ))."</td>";
                            echo "<td>".$this->Html->link('結果をレビュー',array('controller' => 'results','action' => 'view',$item['Result']['id']))."</td>";
                        }
                        else
                        {
                            echo "<td>期限切れ</td>";
                            echo "<td>期限切れ</td>";
                        }
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