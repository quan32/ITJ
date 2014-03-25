<h1>気に入りの講義リスト</h1>
<?php
$paginator = $this->Paginator;
if($hotLectures==NULL){
    echo "<h2>空きデータ</h2>";
    }
    else
{

    echo "<table>";

        echo "<tr>";

            echo "<th>" . $paginator->sort('id', 'ID') . "</th>";
            echo "<th>" . $paginator->sort('name', 'タイトル') . "</th>";
            echo "<th>" . $paginator->sort('fullname', '先生の名前') . "</th>";
            echo "<th>" . $paginator->sort("cost", 'コスト') . "</th>";
            echo "<th>情報</th>";
            echo "<th> Option</th>";
        echo "</tr>";
        

        foreach( $hotLectures as $item ){
                $param = array(
                    'lecture_id' => $item['Lecture']['id'],
                    'action' => 'top_lecture_hot'

                    )         ;
                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['User']['fullname']."</td>";
                echo "<td>".$item['Lecture']['cost']."</td>";
                echo "<td>".$this->Html->link('詳しく',array('controller' => 'Students','action' => 'detailLecture',$item['Lecture']['id'], 'topLecturesHot'));

                echo "<td>";
                if($item['Block'] == 0)
                {
                     $flag = 0;
                    $status = 0; // Status de xem hoc hay chua?
                    foreach ($list_lectures as $lecture) {
                        if ($lecture['Register']['lecture_id'] == $item['Lecture']['id'])
                        {
                            $flag = 1; // = 1 , tuc la trong list cac bai hoc da dang ki
                            $status = $lecture['Register']['status'];
                            break;
                        }
                    }
                    if($flag == 0)

                     {
                        echo $this->html->link("登録",array 
                        ("action"=>"registerLecture",$item['Lecture']['id'],"top_lectures_hot"),array(),"価格は ".$item['Lecture']['cost'].". 本気？",false); 
                        }
                    else
                    {
                        if($status == 0 )
                            echo $this->Html->link("勉強", array("controller" => "lectures","action" => "view" ,$item['Lecture']['id']));
                        else 
                           echo $this->Html->link("見直す", array("controller" => "lectures","action" => "view" ,$item['Lecture']['id']));
                    }
                }
                else
                    echo "ブロック";
                 
           
                echo "</td>";
                   
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


?>