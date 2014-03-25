<h1>受けた講義リスト</h1>
<?php
$paginator = $this->Paginator;

if($registedLectures){

    echo "<table>";

        echo "<tr>";

            echo "<th>" . $paginator->sort('id', 'ID') . "</th>";
            echo "<th>" . $paginator->sort('name', 'タイトル') . "</th>";
            echo "<th>" . $paginator->sort('created', '時間') . "</th>";
            echo "<th>" . $paginator->sort("cost", 'コスト') . "</th>";
            echo "<th>情報</th>";
            echo "<th> 操作 1</th>";
            echo "<th> 操作 2</th>";
            echo "<th> 操作 3</th>";

        echo "</tr>";
        

        foreach( $registedLectures as $item ){

                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['Register']['created']."</td>";
                echo "<td>".$item['Lecture']['cost']."</td>";
                echo "<td>".$this->Html->link('詳しく',array('controller' => 'lectures','action' => 'detail',$item['Lecture']['id'], 'registed_lectures'));
       

            if($item['Block'] == 0)
            {
                // Neu qua mot tuan thi ban ko the hoc
                  $lastWeek = time() - 7*24*60*60;

                  if(strtotime($item['Register']['created']) >= $lastWeek)
                  {
                        if($item['Register']['status'] == 0)
                            echo "<td>".$this->Html->link("勉強",array("controller" => "lectures", "action" => "view",$item['Lecture']['id']))."</td>";
                        else if ($item ['Register']['status'] ==1)
                            echo "<td>".$this->Html->link("見直す",array("controller" => "lectures", "action" => "view",$item['Lecture']['id']))."</td>";
                        if($item['isTest'] == 1)
                                {
                                echo "<td>".$this->Html->link('もう一度テスト',array('controller' => 'tests','action' => 'view',$item['Test']['id'], ))."</td>";
                                echo "<td>".$this->Html->link('結果をレビュー',array('controller' => 'results','action' => 'view',$item['result_id']))."</td>";
                                }
                        else {
                            echo "<td>".$this->Html->link('テスト',array('controller' => 'tests','action' => 'view',$item['Test']['id'], ))."</td>";
                            echo "<td>なし</td>";

                        }
                  }
                  else {
                    echo "<td>".$this->html->link("もう一度登録",array 
                        ("action"=>"registerLecture",'full_base' => true ,$item['Lecture']['id'],"registed_lectures"),array(),"値段は ".$item['Lecture']['cost'].". 登録しますか?",false)."</td>";
                    echo "<td>なし</td>";
                    echo "<td>なし</td>";
                  }


            }
         
            else 
                {
                    echo "<td>ブロック</td>";
                    echo "<td>ブロック</td>";
                    echo "<td>ブロック</td>";
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