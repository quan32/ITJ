<?php
if($lecture==NULL){
    echo "<h2>すみません,見つけられない!</h2>";
    if(isset($currentLocation))
    {
        $this->Html->link('戻る',array('controller' => 'Students', 'action' => $currentLocation),array('class'=>'link_buttonx'));
    }
}
else{

    echo "<table>
    <caption> 具体的に講義の情報を表示します </caption>";

            echo "<tr>";
            echo "<td>講義のID</td>";
            echo "<td>".$lecture[0]['Lecture']['id']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>講義のタイトル</td>";
            echo "<td>".$lecture[0]['Lecture']['name']."</td>";
            echo "</tr>";
        
            echo "<tr>";
            echo "<td>講義の説明</td>";
            echo "<td>".$lecture[0]['Lecture']['name']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>コスト</td>";
            echo "<td>".$COST."VND</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>講義の先生の名前</td>";
            echo "<td>".$lecture[0]['User']['fullname']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>ユーザーネーム</td>";
            echo "<td>".$lecture[0]['User']['username']."</td>";
            echo "</tr>";

 
            echo "</table>";

         if(isset($currentLocation))
            {

                if($lecture[0]['Block'] == 0) 
                {
                        $flag = 0;
                        $status = 0; // Status de xem hoc hay chua?
                        foreach ($list_lectures as $item) {
                            if ($item['Register']['lecture_id'] == $lecture[0]['Lecture']['id'])
                            {
                                $flag = 1;
                                $status = $item['Register']['status'];
                                break;
                            }
                        }
                        if($flag == 0)

                         {

             echo $this->Form->create('Lecture',array('url'=>'registerLecture','onsubmit'=>'return confirm("値段は'.$COST.'VND。 登録しますか?");'));
               echo $this->Form->input('lecture_id', array('value' => $item[0]['Lecture']['id'],'type' => 'hidden'));
               echo $this->Form->input('backLink', array('value' => $currentLocation,'type' => 'hidden'));
               echo $this->Form->end('登録');
           }
                            // echo $this->Html->link("登録",array 
                            // ("controller" => "Students","action"=>"registerLecture" ,$lecture[0]['Lecture']['id'],$currentLocation),array(),"値段は".$COST."VND。 登録しますか?",false); 
                            // }
                        else
                        {
                            if($status == 0 )
                                echo $this->Html->link("勉強", array("controller" => "lectures","action" => "view" ,$lecture[0]['Lecture']['id']),array('class'=>'link_buttonx'));
                            else 
                                echo $this->Html->link("見直す", array("controller" => "lectures","action" => "view" ,$lecture[0]['Lecture']['id']),array('class'=>'link_buttonx'));
                        }
                        echo "<br>";
                    }
                    else
                        echo "あなたは今、この先生にブロックられています。<br>";
                echo $this->Html->link("戻る",array('controller' => 'Students', 'action' => $currentLocation),array('class'=>'link_buttonx'));
            }

}
    ?>