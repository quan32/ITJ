<?php
echo $this->element('search');
// Bang 1 : 5 bai hoc moi dang ki nhat
if($fiveNewestLecture==NULL){
    echo "<h2>Data Empty</h2>";
}
else{

    echo "<table>
    <caption> 5 Bai dang ki moi nhat : </caption>

          <tr>
            <th>Id</th>
            <th>タイトル</th>
            <th>時間</th>
            <th>先生の名前</th>
            <th>Option1</th>
            <th>Option2</th>
          </tr>";
        foreach($fiveNewestLecture as $item){
        echo "<tr>";
        echo "<td>".$item['lectures']['id']."</td>";
        echo "<td>".$item['lectures']['name']."</td>";
        echo "<td>".$item['registers']['created']."</td>";
        echo "<td>".$item['users']['fullname']."</td>";
        echo "<td>".$this->Html->link('勉強',array('controller'=>'lectures','action'=>'view', $item['lectures']['id']))."</td>";
        echo "<td>".$this->Html->link('テスト',array('controller'=>'tests','action'=>'index', $item['lectures']['id']))."</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo $this->Html->link('All', array('controller'=>'Students', 'action'=>'lectures_statistics'));

//bang 2 : 5 bai hot nhat he thong
    if($fiveHotLectures==NULL){
    echo "<h2>Data Empty</h2>";
    }
    else
           { 
            echo "<table>
            <caption> 5 bai hot nhat he thong : </caption>

                  <tr>
                    <th>Id</th>
                    <th>タイトル</th>
                    <th>先生の名前</th>
                     <th>時間</th>
                    <th>Option</th>
                  </tr>";
            foreach($fiveHotLectures as $item){
                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['User']['fullname']."</td>";
                echo "<td>".$item['Lecture']['cost']."</td>";
                echo "<td>";


// check user hien tai da dang ki bai nay chua de hien thi Option cho dung:
                $flag = 0;
                $status = 0; // Status de xem hoc hay chua?
                foreach ($list_lectures as $lecture) {
                    if ($lecture['Register']['lecture_id'] == $item['Lecture']['id'])
                    {
                        $flag = 1;
                        $status = $lecture['Register']['status'];
                        break;
                    }
                }
                if($flag == 0)

                 {
                    echo $this->html->link("登録",array 
                    ("action"=>"/register_lecture",'full_base' => true ,$item['Lecture']['id'],"index"),array(),"Gia cua no la ".$item['Lecture']['cost'].". Are you sure?",false); 
                    }
                else
                {
                    if($status == 0 )
                        echo $this->Html->link("勉強", array("action" => "hoc" ));
                    else 
                        echo $this->Html->link("見直す", array("action" => "hoc" ));
                }



  
                echo "</td>";

                echo "</tr>";
            }
             echo "</table>";
        }
        }

echo $this->Html->link('All', array('controller'=>'Students', 'action'=>'top_lecture_hot'));



// 5 bai test moi tham gia nhat
if($fiveNewestTest==NULL){
    echo "<h2>Data Empty</h2>";
}
else{

    echo "<table>
    <caption> 5 Bai test moi nhat : </caption>

          <tr>
            <th>Id</th>
            <th>タイトル</th>
            <th>Score</th>
            <th>Option</th>

          </tr>";
        foreach($fiveNewestTest as $item){
        echo "<tr>";
        echo "<td>".$item['tests']['id']."</td>";
        echo "<td>".$item['tests']['name']."</td>";
        echo "<td>".$item['results']['score']."</td>";
        echo "<td>".$this->Html->link('もう一度テスト',array('Truyen link o day'))."</td>";
        echo "</tr>";
    }
    echo "</table>";

}
   
echo $this->Html->link('All', array('controller'=>'Students', 'action'=>'result_statistics'));

?>