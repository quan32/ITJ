<?php
echo $this->element('search');
// Bang 1 : 5 bai hoc moi dang ki nhat
if($fiveNewestLecture==NULL){
    echo "<h2>空きデータ</h2>";
}
else{


    echo "<table>
    <h2> 最新の登録した講義 : </h2>

          <tr>
            <th>Id</th>
            <th>タイトル</th>
            <th>時間</th>
            <th>先生の名前</th>
            <th>情報</th>
            <th>操作</th>
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
                        ("action"=>"/register_lecture",'full_base' => true ,$item['Lecture']['id'],"index"),array(),"値段は ".$item['Lecture']['cost'].". 登録しますか?",false); 
                        }
                    else
                    {
                        if($status == 0 )
                            echo $this->Html->link('勉強',array('controller'=>'lectures','action'=>'view', $item['Lecture']['id']));
                        else 
                            echo $this->Html->link('見直す',array('controller'=>'lectures','action'=>'view', $item['Lecture']['id']));
                    }

                     
                }
         
        echo "</tr>";
    }
    echo "</table>";
    echo $this->Html->link('全て', array('controller'=>'Students', 'action'=>'registed_lectures'));

//bang 2 : 5 bai hot nhat he thong
    if($fiveHotLectures==NULL){
    echo "<h2>空きデータ</h2>";
    }
    else
           { 
            echo "<table>
            <h2> 最高の講義 : </h2>

                  <tr>
                    <th>Id</th>
                    <th>タイトル</th>
                    <th>先生の名前</th>
                     <th>コスト</th>
                     <th>情報</th>
                    <th>操作</th>
                  </tr>";
            foreach($fiveHotLectures as $item){
                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['User']['fullname']."</td>";
                echo "<td>".$item['Lecture']['cost']."</td>";
                echo "<td>".$this->Html->link('詳しく',array('controller' => 'lectures','action' => 'detail',$item['Lecture']['id'], 'index'));
                echo "</td>";
                echo "<td>";
          if($item['Block'] == 1){
             echo "ブロック";
                }

        else {

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
                    ("action"=>"/register_lecture",'full_base' => true ,$item['Lecture']['id'],"index"),array(),"値段は ".$item['Lecture']['cost'].". 登録しますか?",false); 
                    }
                else
                {
                    if($status == 0 )
                        echo $this->Html->link('勉強',array('controller'=>'lectures','action'=>'view', $item['Lecture']['id']));
                    else 
                        echo $this->Html->link('見直す',array('controller'=>'lectures','action'=>'view', $item['Lecture']['id']));
                }

 
                
            }
                echo "</td>";

                echo "</tr>";
            }
             echo "</table>";
        }
        }

echo $this->Html->link('全て', array('controller'=>'Students', 'action'=>'top_lectures_hot'));



// 5 bai test moi tham gia nhat
if($fiveNewestTest==NULL){
    echo "<h2>空きデータ</h2>";
}
else{

    echo "<table>
    <h2> 最新の受けたテスト : </h2>

          <tr>
            <th>ID</th>
            <th>タイトル</th>
            <th>点数</th>
            <th>時間</th>
            <th>講義の説明</th>
            <th>操作1</th>
            <th>操作2</th>

          </tr>";
        foreach($fiveNewestTest as $item){
        echo "<tr>";
        echo "<td>".$item['Test']['id']."</td>";
        echo "<td>".$item['Test']['name']."</td>";
        echo "<td>".$item['Result']['score']."</td>";
        echo "<td>".$item['Result']['created']."</td>";
        echo "<td>".$this->Html->link('詳しく',array('controller' => 'lectures','action' => 'detail',$item['Lecture']['id'], 'index'));
        if($item['Block'] == 1){
             echo "<td>ブロック</td>";
             echo "<td>ブロック</td>";
                }
        else{        
            echo "<td>".$this->Html->link('もう一度テスト',array('controller' => 'tests','action' => 'view',$item['Test']['id'], ))."</td>";
            echo "<td>".$this->Html->link('結果をレビュー',array('controller' => 'results','action' => 'view',$item['Result']['id']))."</td>";
        }
        
        echo "</tr>";
    }
    echo "</table>";

}
   
echo $this->Html->link('全て', array('controller'=>'Students', 'action'=>'results_statistics'));

?>