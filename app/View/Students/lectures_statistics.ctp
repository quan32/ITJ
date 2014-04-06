<h1>講義リスト</h1>
<?php
$paginator = $this->Paginator;

if($lectures){

    echo "<table>";

        echo "<tr>";

            echo "<th>" . $paginator->sort('Lecture.id', 'ID') . "</th>";
            echo "<th>" . $paginator->sort('Lecture.name', 'タイトル') . "</th>";
            echo "<th>" . $paginator->sort('User.fullname', '先生の氏名') . "</th>";
            echo "<th>'コスト</th>";
            echo "<th>詳しく</th>";
            echo "<th> 選択</th>";

        echo "</tr>";

        

        foreach( $lectures as $item ){
                $param = array(
                    'lecture_id' => $item['Lecture']['id'],
                    'action' => 'lecture_statistics'

                    )         ;
                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['User']['fullname']."</td>";
                echo "<td>".$COST."VND</td>";
                echo "<td>".$this->Html->link('詳しく',array('controller' => 'Students','action' => 'detailLecture',$item['Lecture']['id'], 'lecturesStatistics'));

                echo "<td>";
            //Check co bi chan ko: 
            if($item['Block'] == 1){
             echo "ブロック";
                }

        else {

            if($item['statusLecture'] == 0)
            {

                echo $this->Form->create('Lecture',array('url'=>'registerLecture','onsubmit'=>'return confirm("値段は'.$COST.'VND。 登録しますか?");'));
               echo $this->Form->input('lecture_id', array('value' => $item['Lecture']['id'],'type' => 'hidden'));
               echo $this->Form->input('backLink', array('value' => 'lecturesStatistics','type' => 'hidden'));
               echo $this->Form->end('登録');
            }
                    // echo $this->html->link("登録",array 
                    // ("action"=>"registerLecture",$item['Lecture']['id'],"lecturesStatistics"),array(),"値段は ".$COST."VND。登録しますか?",false); 
                    
                else
                {
                   
                        echo $this->Html->link('勉強',array('controller'=>'lectures','action'=>'view', $item['Lecture']['id']),array('class'=>'link_buttonx'));
                    
                }

                
            }
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

else{
    echo " 空きデータ";
}


?>