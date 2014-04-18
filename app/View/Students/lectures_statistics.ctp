<h1>講義リスト</h1><br />
<?php echo $this->Form->create('Students',array('action'=>'lecturesStatistics'));?>
    <fieldset>
        <legend><?php __('漉す');?></legend>
     <table class="search_box">
            <tr>
                <td class="td2"><?php echo $this->Form->input('catagory', array('label'=>'','options'=>array('0'=>'全部','1'=>'数学','2'=>'文学','3'=>'外国語','4'=>'体育','5'=>'普通科学','6'=>'IT','7'=>'食品','8'=>'社会','9'=>'心理','10'=>'芸術'))); ?></td>
                <td class="td3"><?php echo $this->Form->submit('漉す'); ?></td>
            </tr>
        </table>
    </fieldset>
<?php echo $this->Form->end();?>
<?php
$paginator = $this->Paginator;

if($lectures){

    echo "<table>";

        echo "<tr align='center'>";

            echo "<th>" . $paginator->sort('Lecture.id', 'ID') . "</th>";
            echo "<th>" . $paginator->sort('Lecture.name', 'タイトル') . "</th>";
            echo "<th>" . $paginator->sort('User.fullname', '先生の氏名') . "</th>";
            echo "<th>コスト</th>";
            echo "<th>詳しく</th>";
            echo "<th> 選択</th>";

        echo "</tr>";

        

        foreach( $lectures as $item ){
                $param = array(
                    'lecture_id' => $item['Lecture']['id'],
                    'action' => 'lecture_statistics'

                    )         ;
                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['User']['fullname']."</td>";
                echo "<td>".$COST."VND</td>";
                echo "<td>".$this->Html->link('詳しく',array('controller' => 'Students','action' => 'detailLecture',$item['Lecture']['id'], 'lecturesStatistics'));

                echo "<td>";
            //Check co bi chan ko: 
            if($item['Block'] == 1){
             echo "ブロック";
                }

        else {

            if($item['statusLecture'] == 0)
            {

            echo $this->Html->link('登録',array('controller' => 'Students','action' => 'detailLecture',$item['Lecture']['id'], 'lecturesStatistics'),array('class'=>'link_buttonx'));
               //  echo $this->Form->create('Lecture',array('url'=>'registerLecture','onsubmit'=>'return confirm("値段は'.$COST.'VND。 登録しますか?");'));
               // echo $this->Form->input('lecture_id', array('value' => $item['Lecture']['id'],'type' => 'hidden'));
               // echo $this->Form->input('backLink', array('value' => 'lecturesStatistics','type' => 'hidden'));
               // echo $this->Form->end('登録');
            }
                    // echo $this->html->link("登録",array 
                    // ("action"=>"registerLecture",$item['Lecture']['id'],"lecturesStatistics"),array(),"値段は ".$COST."VND。登録しますか?",false); 
                    
                else
                {
                   
                        echo $this->Html->link('勉強',array('controller'=>'lectures','action'=>'view', $item['Lecture']['id']),array('class'=>'link_buttonx'));
                    
                }

                
            }
                echo "</td>";
                      
                echo "</tr>";
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
        echo $this->Paginator->counter('ページ {:page} / {:pages}');    
    echo "</div>";
    
}

else{
    echo " 空きデータ";
}


?>

<style type="text/css">
    table tr td{
        padding:15px;
    }
	td.td1{
        width:60%;
        margin-top:2px!important;
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