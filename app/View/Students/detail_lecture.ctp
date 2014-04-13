<?php
if(!isset($lecture)){
    echo "<h2>すみません,見つけられない!</h2>";
    if(isset($backLink))
    {
       
      echo $this->Html->link('戻る',array('controller' => 'Students', 'action' => $backLink),array('class'=>'link_buttonx'));
    }
}
else{
    if($lecture == null)
    {
        echo "<h2>すみません,見つけられない!</h2>";
        if(isset($backLink))
        {
           
          echo $this->Html->link('戻る',array('controller' => 'Students', 'action' => $backLink),array('class'=>'link_buttonx'));
        }
    }
    else
    {

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
                echo "<span color='red!important'>あなたは今、この先生にブロックられています。</span><br><br>"; 
                if(isset($backLink)){
                        echo $this->Html->link('戻る',array('controller' => 'Students', 'action' => $backLink),array('class'=>'link_buttonx'));
                    } 
            }                    

            else
            {

                if($lecture[0]['statusLecture'] == 0)
                {
                  // chuan bi dang ki

                echo $this->Form->create('Lecture',array('url'=>'registerLecture','onsubmit'=>'return confirm("値段は'.$COST.'VND。 買いますか?");'));
                echo $this->Form->input('lecture_id', array('value' => $lecture[0]['Lecture']['id'],'type' => 'hidden'));
                if($backLink != null)
                    echo $this->Form->input('backLink', array('value' => $backLink,'type' => 'hidden'));
                else 
                    echo $this->Form->input('backLink', array('value' => 'registedLectureThisWeek','type' => 'hidden'));

                echo "<br><table><tr>";
                    if(isset($backLink)){
                    echo "<td>".$this->Html->link('戻る',array('controller' => 'Students', 'action' => $backLink),array('class'=>'link_buttonx'))
                    ."</td>";
                    }
                    echo "<td>".$this->Form->end('買う')."</td>";
                echo "</tr></table>";

                }                       
                else{
                    echo "<br>";
                    if(isset($backLink)){
                        echo $this->Html->link('戻る',array('controller' => 'Students', 'action' => $backLink),array('class'=>'link_buttonx'));
                    } 
                   
                    echo $this->Html->link('勉強',array('controller'=>'lectures','action'=>'view', $lecture[0]['Lecture']['id']),array('class'=>'link_buttonx'));
                    
                }
                 
            }                     

}
}
    ?>

<style type="text/css">
    body{
        color:red;
    }
    table{
        border:1px solid dotted!important;
    }
    form div.submit{
        margin-top:0px!important;
    }
</style>