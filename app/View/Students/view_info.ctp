<?php
if(!isset($info))
{
    echo "Empty data";
}
else
{

        echo "<table>";

            echo "<tr>";
            echo "<th></th>";
            echo "<th></th>";
            echo "</tr>";
       
            echo "<tr>";
            echo "<th>氏名</th>";
            echo "<th>".$info['User']['fullname']."</th>";
            echo "</tr>";
        
            echo "<tr>";
            echo "<th>誕生日</th>";
            echo "<th>".$info['User']['date_of_birth']."</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>性別</th>";
            echo "<th>".$info['User']['sex']."</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>住所</th>";
            echo "<th>".$info['User']['address']."</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>メール</th>";
            echo "<th>".$info['User']['mail']."</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>電話番号</th>";
            echo "<th>".$info['User']['mobile_No']."</th>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<th>クレジットカード</th>";
            echo "<th>".$info['User']['credit_card_No']."</th>";
            echo "</tr>";


    echo $this->Html->link('変化', array('controller'=>'students','action'=>'/edit_info'));
    echo $this->Html->link(' Xoa tai khoan - アカウントの利用解除', array('controller'=>'students','action'=>'del_account'));

}

?>