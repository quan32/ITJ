<?php

if($exist == 1)
    {
        if($permission == 0)
        {
            echo 'すみません、許可がありません。';
        }
        else
        {
            if($hasTest == 1){

                if($data != null)
                {
                    echo "<table>
                    <h2> この講義のテストのリストを表示します。 : </h2>

                          <tr>
                            <th>タイトル</th>
                            <th>テスト</th>
                            <th>結果</th>
                          </tr>";
                        foreach($data as $item){
                        echo "<tr>";
                        echo "<td>".$item['Test']['name']."</td>";
                       
                        if($item['HasResult'] == 0)
                        {
                            echo "<td>".$this->Html->link('受ける',array('controller' => 'Tests','action' => 'view',$item['Test']['id']))."</td>";
                            echo "<td>なし</td>";
                        }
                        else
                        {
                            echo "<td>".$this->Html->link('もう一度',array('controller' => 'Tests','action' => 'view',$item['Test']['id']))."</td>";
                            echo "<td>".$this->Html->link('見直す',array('controller' => 'Results','action' => 'view',$item['Result_id'])). "</td>"     ;
                        }
                         
                         
                    }
                    echo "</table>";
         
                }
                else
                {
                   echo 'すみません、この講義テストがありません。'; 
                }
            }
        //ko co test
            else 
            {
                echo 'すみません、この講義テストがありません。';
            }
        }
    }
    else echo 'すみません、この講義テストがありません。';
?>