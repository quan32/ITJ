<?php
if(!isset($lecture)){
    echo "<h2>すみません,見つけられない!</h2>";
    if(isset($backLink))
    {
       
      echo $this->Html->link('戻る',array('controller' => 'Students', 'action' => $backLink),array('class'=>'link_buttonx'));
    }
}
else{

    echo "<table>
    <caption><br /> <h3>講義の詳しい情報<h3><br /> </caption>";

            echo "<tr>";
            echo "<td>講義ID</td>";
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
            echo "<td>作成者</td>";
            echo "<td>".$lecture[0]['User']['fullname']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>ユーザ名</td>";
            echo "<td>".$lecture[0]['User']['username']."</td>";
            echo "</tr>";

 
            echo "</table>";

            if($lecture[0]['Block'] == 1)
            {
                echo "あなたは今、この先生にブロックられています。<br>"; 
            }                    

            else
            {

                if($lecture[0]['statusLecture'] == 0)
                {
                  // chuan bi dang ki
                echo $this->Form->create('Lecture',array('url'=>'registerLecture','onsubmit'=>'return confirm("値段は'.$COST.'VND。 登録しますか?");'));
                echo $this->Form->input('lecture_id', array('value' => $lecture[0]['Lecture']['id'],'type' => 'hidden'));
                if($backLink != null)
                    echo $this->Form->input('backLink', array('value' => $backLink,'type' => 'hidden'));
                else 
                    echo $this->Form->input('backLink', array('value' => 'registedLectureThisWeek','type' => 'hidden'));
                echo $this->Form->end('登録');

                }                       
                else
                {
                   
                  echo $this->Html->link('勉強',array('controller'=>'lectures','action'=>'view', $lecture[0]['Lecture']['id']),array('class'=>'link_buttonx'));
                    
                }
                 
            }


    if(isset($backLink))
    {
        echo $this->Html->link('戻る',array('controller' => 'Students', 'action' => $backLink),array('class'=>'link_buttonx'));
    }                      

}
    ?>

<style type="text/css">
    table{
        border:1px solid dotted!important;
    }
</style>