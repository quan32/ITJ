<?php

if($info==NULL){
    echo "<h2>空きデータ</h2>";
}
else{

    echo "<div>";
 
        echo "<table>";
       
            echo "<tr>";
            echo "<th>氏名</th>";
            echo "<td>".$info['User']['fullname']."</td>";
            echo "</tr>";
        
            echo "<tr>";
            echo "<th>誕生日</th>";
            echo "<td>".$info['User']['date_of_birth']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>電話番号</th>";
            echo "<td>".$info['User']['mobile_No']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>メール</th>";
            echo "<td>".$info['User']['mail']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>アドレス</th>";
            echo "<td>".$info['User']['address']."</td>";
            echo "</tr></table>";

    echo "<button>".$this->Html->link('編集　  ', array('controller'=>'teachers','action'=>'edit',$user_id))."</button>";
    echo "<button>".$this->Html->link('パスワード変化　　', array('controller'=>'users','action'=>'changePassword'))."</button>";
    echo "<button>".$this->Form->postLink('　削除   ', array('controller'=>'users','action'=>'delete',$user_id),
        array('confirm'=>'本気？'))."</button>";
    echo "</div>";


}


?>