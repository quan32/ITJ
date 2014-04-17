<?php echo $this->Form->create('formstudent');?>
    <fieldset>
     <table class="search_box">
            <tr>
                <td class="td1"><?php echo $this->Form->input('keyword',array('label'=>'ユーザ')); ?></td>
                <td class="td3"><?php echo $this->Form->submit('検索'); ?></td>
            </tr>
        </table>
    </fieldset>
<?php echo $this->Form->end();?>

<?php
//debug($posts); die;
if(!empty($students)){
$paginator = $this->Paginator;
    echo "<table>";

        echo "<tr align='center'>";

            echo "<th>" . $paginator->sort('User.username', 'ユーザ名') . "</th>";
            echo "<th>" . $paginator->sort('User.fullname', '氏名') . "</th>";
            echo "<th>資格</th>";
            echo "<th>統計</th>";
            echo "<th>管理</h1>";

        echo "</tr>";
       // debug($users); die();
        
    
    foreach ($students as $student) {

        echo '<tr>';
            echo '<td>'.$student["User"]["username"].'</td>';
            echo '<td>'.$student["User"]["fullname"].'</td>';
            echo '<td>'.$student["User"]["role"].'</td>';
            echo '<td>';
            echo $this->Html->link('見る', 
                array('controller'=>'teachers','action' => 'statisticsStudent', $student["User"]["id"]));
            echo '</td>';    
            // xu ly block, unblock       
        echo '<td>';
        if($student['Block'] == 0){

              echo $this->Form->create('Block',array('action' => 'blockStudent'));
              echo $this->Form->input('studentID', array('value' => $student['User']['id'],'type' => 'hidden'));
               echo $this->Form->input('backLink', array('value' => 'listStudents','type' => 'hidden'));
               echo $this->Form->end('ブロッグ');
           }
        else
        {
               echo $this->Form->create('Block',array('action' => 'unblockStudent'));
               echo $this->Form->input('studentID', array('value' => $student['User']['id'],'type' => 'hidden'));
               echo $this->Form->input('backLink', array('value' => 'listStudents','type' => 'hidden'));
               echo $this->Form->end('アンブロック');
        }
            
        echo "</td>";    

        echo '</tr>';
    
    }
    echo "</table>";
    echo "<div class='paging'>";

        echo $paginator->first("初");

        if($paginator->hasPrev()){
            echo $paginator->prev("前");
        }

        echo $paginator->numbers(array('modulus' => 2));

        if($paginator->hasNext()){
            echo $paginator->next("次");
        }

        echo $paginator->last("後");
    
    echo "</div>";
}
?>

<style type="text/css">
    td.td1{
        width:60%;
        margin-top:2px!important;
    }
    .search_box input[type="text"]{
        width:600px;
    }

    td.td2{
        width:10%;
    }

    td.td3{
        height:30px;
        padding:0px;
        margin:0px;
    }

    form .submit input[type=submit]{
        padding:5px;
        margin:0px;
    }
    

</style>
