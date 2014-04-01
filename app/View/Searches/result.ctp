<?php 
    $this->Paginator->options(array('url' => $this->passedArgs));
?>
<?php echo $this->Form->create('Search',array('action'=>'search'));?>
    <fieldset>
        <legend><?php __('検索');?></legend>
    <?php
		echo $this->Form->input('catagory', array('label'=>'カテゴリ', 'options'=>array('0'=>'全部','1'=>'数学','2'=>'文学','3'=>'外国語')));
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
    echo "<th>".$this->Paginator->sort("count","登録した学生の数"); //TODO
    if($view_regis == 1) echo "<th>すぐ登録";
    echo "</tr>";
    
    foreach($posts as $item){
        echo "<tr>";
        echo "<td>".$item['Search']['id']."</td>";
        echo "<td>".$item['Search']['name']."</td>";
        echo "<td>".$item['Search']['description']."</td>";
        echo "<td>".$item['User']['fullname']."</td>";
        echo "<td>".count($item['Register'])."</td>";
        if($view_regis ==1 && $teacher_id != $item['User']['id']) echo "<td>".$this->html->link("登録",array 
                    ('controller' => 'Students',"action"=>"registerLecture",$item['Search']['id']),array(),"",false); 
        echo "</tr>";
    }
    echo "</table>";
    
    //---- Paging 
	//echo $this->Paginator->numbers();
	//echo $this->Paginator->numbers(array('last' => 'Last page'));
	//debug($this->Paginator->param('pageCount'));
	if($this->Paginator->param('pageCount') >1)
	{
		echo $this->Paginator->prev('« 前のページ ', null, null, array('class' => 'disabled')); //Shows the next and previous links
    
		echo " | ".$this->Paginator->numbers()." | "; //Shows the page numbers
    
		echo $this->Paginator->next(' 次のページ »　', null, null, array('class' => 'disabled')); //Shows the next and previous links
    }
    echo " ".$this->Paginator->counter(array(
    'format' => 'range'
	//'separator' => ' of'
	)); // prints X of Y, where X is current page and Y is number of pages
} else {echo "空きデータ";}
?>