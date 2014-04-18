<?php
    App::import("Model", "User");
    $UserModel = new User();
?>
<?php echo $this->Html->css('lecture_view');?>
<?php
if(!isset($lecture)){
    echo "<h2 class='detail_lecture_error'>すみません,見つけられない!</h2>";
}
else{
    if($lecture == null)
    {
        echo "<h2 class='detail_lecture_error'>すみません,見つけられない!</h2>";
        
    }
    else
    {

             echo "<table>
            <caption><br /> <h3>講義の詳しい情報<h3><br /> </caption>";

            echo "<tr>";
            echo "<td>講義ID</td>";
            echo "<td>".$lecture['Lecture']['id']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>講義のタイトル</td>";
            echo "<td>".$lecture['Lecture']['name']."</td>";
            echo "</tr>";
        
            echo "<tr>";
            echo "<td>講義の説明</td>";
            echo "<td>".$lecture['Lecture']['name']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>コスト</td>";
            echo "<td>".$COST."VND</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>作成者</td>";
            echo "<td>".$lecture['User']['fullname']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>ユーザ名</td>";
            echo "<td>".$lecture['User']['username']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>「いいね！」した人数</td>";
            echo "<td>".$num_liked."</td>";
            echo "</tr>";

            echo "</table>";
           if($canReport == 1) echo $this->Html->link('レポート',array('controller' => 'Reports','action' => 'index',$lecture['Lecture']['id'], $lecture['Lecture']['name'],$lecture['User']['fullname']),array('class'=>'link_buttonx'));
            echo "<br>";
                          

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