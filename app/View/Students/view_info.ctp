<h1>Thong tin ca nhan</h1>
<div class="col-lg-6">
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
            echo "<td></td>";
            echo "</tr>";
       
            echo "<tr>";
            echo "<th>氏名</th>";
            echo "<td>".$info['User']['fullname']."</td>";
            echo "</tr>";
        
            echo "<tr>";
            echo "<th>誕生日</th>";
            echo "<td>".$info['User']['date_of_birth']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>性別</th>";
            echo "<td>".$info['User']['sex']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>住所</th>";
            echo "<td>".$info['User']['address']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>メール</th>";
            echo "<td>".$info['User']['mail']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>電話番号</th>";
            echo "<td>".$info['User']['mobile_No']."</td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<th>クレジットカード</th>";
            echo "<td>".$info['User']['credit_card_No']."</td>";
            echo "</tr></table>";


    echo "<button>".$this->Html->link('変化', array('controller'=>'students','action'=>'/edit_info'))."</button>";
    echo "<button>".$this->Html->link(' Xoa tai khoan - アカウントの利用解除', array('controller'=>'students','action'=>'del_account'))."</button>";

}
?>
</div>