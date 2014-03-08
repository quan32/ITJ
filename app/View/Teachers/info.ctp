<?php

if($info==NULL){
    echo "<h2>Dada Empty</h2>";
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
            echo "</tr>";

    echo $this->Html->link('Edit', array('controller'=>'teachers','action'=>'edit',$user_id));
    echo $this->Html->link('Change password', array('controller'=>'teachers','action'=>'changePassword'));
    echo $this->Html->link('Statistic', array('controller'=>'teachers','action'=>'statistic'));
    echo $this->Html->link('View result', array('controller'=>'teachers','action'=>'viewResult'));
    echo $this->Form->postLink('Delete', array('controller'=>'users','action'=>'delete',$user_id),
        array('confirm'=>'Ban co chac khong?'));

    echo "</div>";


}


?>