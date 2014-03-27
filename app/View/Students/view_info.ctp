<h1>自身情報</h1>
<div class="col-lg-6">
<?php
if(!isset($info))
{
    echo "空きデータ";
}
else
{

        echo "<table>";

            echo "<tr>";
            echo "<td></td>";
            echo "<td></td>";
            echo "</tr>";
       
            echo "<tr>";
            echo "<td>氏名</td>";
            echo "<td>".$info['User']['fullname']."</td>";
            echo "</tr>";
        
            echo "<tr>";
            echo "<td>誕生日</td>";
            echo "<td>".$info['User']['date_of_birth']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>性別</td>";
            echo "<td>".$info['User']['sex']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>住所</td>";
            echo "<td>".$info['User']['address']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>メール</td>";
            echo "<td>".$info['User']['mail']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>電話番号</td>";
            echo "<td>".$info['User']['mobile_No']."</td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td>クレジットカード</td>";
            echo "<td>".$info['User']['credit_card_No']."</td>";
            echo "</tr></table>";


    echo "<button>".$this->Html->link('変化', array('controller'=>'students','action'=>'editInfo'))."</button>";
    echo "<button>".$this->Html->link('アカウントの利用解除', array('controller'=>'students','action'=>'delAccount'))."</button>";

}
?>
</div>