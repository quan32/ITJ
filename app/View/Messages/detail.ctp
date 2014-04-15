<h1>メッセージの内容</h1><br />
<?php
//debug($mess_data);
//debug($lec_data); die;
echo "<table>";
       
            echo "<tr>";
            echo "<td>もらう時間</td>";
            echo "<td>".$mess_data[0]['Message']['created']."</td>";
            echo "</tr>";
        
            echo "<tr>";
            echo "<td>内容</td>";
            echo "<td>".$mess_data[0]['Message']['content']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>講義タイトル</td>";
            echo "<td>".$lec_data[0]['Lecture']['name']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>講義を編集</td>";
            echo "<td>".$this->Html->link('編集',array('controller'=>'lectures','action' => 'edit',$lec_data[0]['Lecture']['id']))."</td>";
            echo "</tr>";
            echo "</table>";
echo $this->Html->link('　戻る　',array('action' => 'viewall'),array('class'=>'link_buttonx'));
?>