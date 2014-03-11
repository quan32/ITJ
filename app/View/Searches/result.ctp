<?php 
    $this->Paginator->options(array('url' => $this->passedArgs));
?>
<?php echo $this->Form->create('Search',array('action'=>'search'));?>
    <fieldset>
        <legend><?php __('検索');?></legend>
    <?php
        echo $this->Form->input('keyword');
        //echo $this->Form->input('description');
        echo $this->Form->submit('検索');
    ?>
    </fieldset>
<?php echo $this->Form->end();?>

<?php
if(!empty($posts)){
    echo "<table>";
    echo "<tr>";
    echo "<th>".$this->Paginator->sort("id","ID");
    echo "<th>".$this->Paginator->sort("name","タイトル");
    echo "<th>".$this->Paginator->sort("description","紹介する情報");
    echo "<th>".$this->Paginator->sort("fullname","作成した先生");
    echo "<th>".$this->Paginator->sort("Description","登録した学生の数");
    echo "<th>すぐ登録";
    echo "</tr>";
    
    foreach($posts as $item){
        echo "<tr>";
        echo "<td>".$item['Search']['id']."</td>";
        echo "<td>".$item['Search']['name']."</td>";
        echo "<td>".$item['Search']['description']."</td>";
        echo "<td>".$item['User']['fullname']."</td>";
        echo "<td>".count($item['Register'])."</td>";
        echo "<td>".$this->Html->link("登録", array("controller"))."</td>"; //link to register of Xuan
        echo "</tr>";
    }
    echo "</table>";
    
    //---- Paging 
    echo $this->Paginator->prev('« 前のページ ', null, null, array('class' => 'disabled')); //Shows the next and previous links
    
    echo " | ".$this->Paginator->numbers()." | "; //Shows the page numbers
    
    echo $this->Paginator->next(' 次のページ »', null, null, array('class' => 'disabled')); //Shows the next and previous links
    
    echo " ページ ".$this->Paginator->counter(); // prints X of Y, where X is current page and Y is number of pages
}// else {echo "data empty";}
?>