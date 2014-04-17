<?php

if($hasTest == 1){

    if($data != null)
    {
        echo "<table>
        <h2> この講義のテストのリスト</h2><br />

              <tr>
                <th>タイトル</th>
                <th>テスト</th>
                <th>結果</th>
              </tr>";
            foreach($data as $item){
                if($item['Test']['state']=='blocked'){
                    echo "<tr><td><span class='student_test_blocked'>このテストは管理者によってブロックさせられた。<span></td></tr>";
                }
                else{
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
?>

<style type="text/css">
    .student_test_blocked{
        color:red;
    }
</style>