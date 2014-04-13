<?php

if($info==NULL){
    echo "<h2>空きデータ</h2>";
}
else{
    echo "<h1>自身情報</h1><br />";
    echo "<div>";
 
        echo "<table>";
       
            echo "<tr>";
            echo "<td>氏名</td>";
            echo "<td>".$info['User']['fullname']."</td>";
            echo "</tr>";
        
            echo "<tr>";
            echo "<td>誕生日</td>";
            echo "<td>".$info['User']['date_of_birth']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>電話番号</td>";
            echo "<td>".$info['User']['mobile_No']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>メール</td>";
            echo "<td>".$info['User']['mail']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>アドレス</td>";
            echo "<td>".$info['User']['address']."</td>";
            echo "</tr></table>";

    echo "<button class = ".'"link_buttonx"'.">".$this->Html->link('編集', array('controller'=>'teachers','action'=>'edit',$user_id))."</button>";
    echo "<button class = ".'"link_buttonx"'.">".$this->Html->link('パスワード変化', array('controller'=>'users','action'=>'changePassword'))."</button>";
    echo "<button class = ".'"link_buttonx"'.">".$this->Html->link('確認するコード変更', array('controller'=>'teachers','action'=>'changeVerify'))."</button>";
    echo "<button class = ".'"link_buttonx"'." >".$this->Form->postLink('アカウント削除', array('controller'=>'users','action'=>'delete',$user_id),
        array('confirm'=>'本気？'))."</button>";
    echo "</div>";


}


?>

<style type="text/css">
    button{
        height:37px;
    }
</style>