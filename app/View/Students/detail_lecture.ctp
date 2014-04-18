<?php
    App::import("Model", "User");
    $UserModel = new User();
?>
<?php echo $this->Html->css('lecture_view');?>
<?php
if(!isset($lecture)){
    echo "<h2 class='detail_lecture_error'>すみません,見つけられない!</h2>";
    if(isset($backLink))
    {
       
      echo $this->Html->link('戻る',array('controller' => 'Students', 'action' => $backLink),array('class'=>'link_buttonx'));
    }
}
else{
    if($lecture == null)
    {
        echo "<h2 class='detail_lecture_error'>すみません,見つけられない!</h2>";
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

            echo "<tr>";
            echo "<td>「いいね！」した人数</td>";
            echo "<td>".$num_liked."</td>";
            echo "</tr>";

            echo "</table>";
			echo $this->Html->link('レポート',array('controller' => 'Reports','action' => 'index',$lecture[0]['Lecture']['id'], $lecture[0]['Lecture']['name'],$lecture[0]['User']['fullname']),array('class'=>'link_buttonx'));
			echo "<br>";
            if($lecture[0]['Block'] == 1)
            {
                echo "<span class='detail_lecture_error'>あなたは今、この先生にブロックられています。</span><br><br>"; 
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
                    echo $this->Form->input('backLink', array('value' => 'recentRegistedLecture','type' => 'hidden'));

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
<hr>
<ul class="nested-comments-complex">
    <?php foreach ($comments as $value): ?>
        <li>
            <div class="comment">
                <p><a href="#" class="author"><?= $UserModel->username($value['Comment']['user_id']); ?></a></p>
                <p><?= $value['Comment']['content']; ?></p>
                <em><?= $value['Comment']['created']; ?></em>
            </div>
            <ul>
                <?php foreach ($value['Reply'] as $reply): ?>
                    <li>
                        <div class="comment">
                            <p><a href="#" class="author"><?= $UserModel->username($reply['user_id']); ?></a></p>
                            <p><?= $reply['content']; ?></p>
                            <em><?= $reply['created']; ?></em>
                        </div>
                    </li>
                <?php endforeach; ?>
                <li id="reply<?= $value['Comment']['id']; ?>" style="display:none;">                    
                    <div class="comment">
                        <p><a href="" class="author">あなた</a></p>
                        <textarea class="reply_text" id="<?= $value['Comment']['id']; ?>">コメントを投稿する...</textarea>
                    </div>
                </li>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>
<style type="text/css">
    .detail_lecture_error{
        color:red;
    }
    table{
        border:1px solid dotted!important;
    }
    form div.submit{
        margin-top:0px!important;
    }
</style>