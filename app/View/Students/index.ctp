<?php
echo $this->element('search');
// Bang 1 : 5 bai hoc moi dang ki nhat
if($fiveNewestLecture!=NULL){


    echo "<table>
    <h2> 一週間の中、最新の買った講義 : </h2>

          <tr>
            <th>Id</th>
            <th>タイトル</th>
            <th>時間</th>
            <th>先生の名前</th>
            <th>情報</th>
            <th>勉強</th>
          </tr>";
        foreach($fiveNewestLecture as $item){
        echo "<tr>";
        echo "<td>".$item['Lecture']['id']."</td>";
        echo "<td>".$item['Lecture']['name']."</td>";
        echo "<td>".$item['Register']['created']."</td>";
        echo "<td>".$item['User']['fullname']."</td>";
        echo "<td>".$this->Html->link('詳しく',array('controller' => 'lectures','action' => 'detail',$item['Lecture']['id'], 'index'));
          
          echo "</td>";
          echo "<td>";
        //Check co bi chan ko: 
            if($item['Block'] == 1){
                 echo "ブロック";
                    }

            else {

    // check user da hoc chua de hien thi cho dung

                       if($item['Register']['status']== 0 )
                            echo $this->Html->link('勉強',array('controller'=>'lectures','action'=>'view', $item['Lecture']['id']));
                        else 
                            echo $this->Html->link('見直す',array('controller'=>'lectures','action'=>'view', $item['Lecture']['id']));
                                        
                }
         
        echo "</tr>";
    }
    echo "</table>";
    echo $this->Html->link('全て', array('controller'=>'Students', 'action'=>'registedLectures'));
}

//bang 2 : 5 bai hot nhat he thong
    if($fiveHotLectures!=NULL)
           { 
            echo "<table>
            <h2> 最高の講義 : </h2>

                  <tr>
                    <th>ID</th>
                    <th>タイトル</th>
                    <th>先生の名前</th>
                     <th>コスト</th>
                     <th>情報</th>
                    <th>選択</th>
                  </tr>";
            foreach($fiveHotLectures as $item){
                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['User']['fullname']."</td>";
                echo "<td>".$cost."VND</td>";
                echo "<td>".$this->Html->link('詳しく',array('controller' => 'lectures','action' => 'detail',$item['Lecture']['id'], 'index'));
                echo "</td>";
                echo "<td>";
          if($item['Block'] == 1){
             echo "ブロック";
                }

        else {

            if($item['statusLecture'] == 0)
                    echo $this->html->link("登録",array 
                    ("action"=>"/register_lecture",'full_base' => true ,$item['Lecture']['id'],"index"),array(),"値段は ".$item['Lecture']['cost'].". 登録しますか?",false); 
                    
                else
                {
                   
                        echo $this->Html->link('登録した,勉強',array('controller'=>'lectures','action'=>'view', $item['Lecture']['id']));
                    
                }

                
            }
                echo "</td>";

                echo "</tr>";
            }
             echo "</table>";
        echo $this->Html->link('全て', array('controller'=>'Students', 'action'=>'topLecturesHot'));
        }

   
 
  
?>