<?php
if($lecture==NULL){
    echo "<h2>すみません,見つけられない!</h2>";
    if(isset($currentLocation))
    {
        $this->Html->link('戻る',array('controller' => 'Students', 'action' => $currentLocation));
    }
}
else{

    echo "<table>
    <caption> 具体的に講義の情報を表示します </caption>";

            echo "<tr>";
            echo "<th>講義のID</th>";
            echo "<th>".$lecture[0]['Lecture']['id']."</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>講義のタイトル</th>";
            echo "<th>".$lecture[0]['Lecture']['name']."</th>";
            echo "</tr>";
        
            echo "<tr>";
            echo "<th>講義の説明</th>";
            echo "<th>".$lecture[0]['Lecture']['name']."</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>コスト</th>";
            echo "<th>".$lecture[0]['Lecture']['cost']."</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>講義の先生の名前</th>";
            echo "<th>".$lecture[0]['User']['fullname']."</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>ユーザーネーム</th>";
            echo "<th>".$lecture[0]['User']['username']."</th>";
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
                            echo $this->Html->link("登録",array 
                            ("controller" => "Students","action"=>"register_lecture" ,$lecture[0]['Lecture']['id'],$currentLocation),array(),"Gia cua no la ".$lecture[0]['Lecture']['cost'].". Are you sure?",false); 
                            }
                        else
                        {
                            if($status == 0 )
                                echo $this->Html->link("勉強", array("controller" => "lectures","action" => "view" ,$lecture[0]['Lecture']['id']));
                            else 
                                echo $this->Html->link("見直す", array("controller" => "lectures","action" => "view" ,$lecture[0]['Lecture']['id']));
                        }
                        echo "<br>";
                    }
                    else
                        echo "あなたは今、この先生にブロックられています。<br>";
                echo $this->Html->link("戻る",array('controller' => 'Students', 'action' => $currentLocation));
            }

}
    ?>