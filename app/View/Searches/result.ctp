<?php 
    $this->Paginator->options(array('url' => $this->passedArgs));
?>
<?php echo $this->Form->create('Search',array('action'=>'search'));?>
    <fieldset>
        <legend><?php __('検索');?></legend>
     <table class="search_box">
            <tr>
                <td class="td1"><?php echo $this->Form->input('keyword',array('label'=>'','value'=>$key)); ?></td>
                <td class="td2"><?php echo $this->Form->input('catagory', array('label'=>'','options'=>array('0'=>'全部','1'=>'数学','2'=>'文学','3'=>'外国語','4'=>'体育','5'=>'普通科学','6'=>'IT','7'=>'食品','8'=>'社会','9'=>'心理','10'=>'芸術'))); ?></td>
                <td class="td3"><?php echo $this->Form->submit('検索'); ?></td>
            </tr>
        </table>
    </fieldset>
<?php echo $this->Form->end();?>
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
<?php
//debug($posts); die;
if(!empty($posts)){
    echo "<table>";
    echo "<tr>";
    echo "<th>".$this->Paginator->sort("id","ID");
    echo "<th>".$this->Paginator->sort("name","タイトル");
    echo "<th>".$this->Paginator->sort("description","紹介する情報");
    echo "<th>".$this->Paginator->sort("fullname","作成した先生");
    echo "<th>登録した数 "; //TODO
	if($view_regis ==0 ) echo "<th> | 状態 </th>";
    if($view_regis == 1) { echo "<th>| すぐ登録";}else{ echo "<th>| 操作</th>";}
    echo "</tr>";
    
    foreach($posts as $item){
        echo "<tr>";
        echo "<td>".$item['Search']['id']."</td>";
        echo "<td>".$item['Search']['name']."</td>";
        echo "<td>".$item['Search']['description']."</td>";
        echo "<td>".$item['User']['fullname']."</td>";
        echo "<td align = right>".count($item['Register'])."</td>";
		if($view_regis ==0 ) {
			echo "<td>";
			if($item['Search']['reported'] == 1) {
				echo "レポートさせた</td>";
			}else {
					echo "         </td>";}
					}
        if($view_regis ==1) echo "<td>".$this->Html->link('詳しく',array('controller' => 'Students','action' => 'detailLecture',$item['Search']['id'], 'index'));
		if($view_regis  == 2 && $item['User']['id'] != $teacher_id) echo "<td>".$this->Html->link('レポート',array('controller' => 'Reports','action' => 'index',$item['Search']['id'], $item['Search']['name'],$item['User']['fullname']));
		if($item['User']['id'] == $teacher_id && $menu_type == "teacher_menu") echo "<td>".$this->Html->link('編集　',array('controller'=>'lectures','action' => 'edit',$item['Search']["id"]));
		if($view_regis == 0) echo "<td>".$this->Html->link('表現', array('controller'=>'lectures','action' => 'view', $item['Search']["id"]))."</td>";
		//.$this->html->link("登録",array 
        //            ('controller' => 'Students','action' =>"registerLecture",$item['Search']['id'],"lecturesStatistics"),array(),"",false); ; 
        echo "</tr>";
    }
    echo "</table>";
    
    //---- Paging 
	//echo $this->Paginator->numbers();
	//echo $this->Paginator->numbers(array('last' => 'Last page'));
	//debug($this->Paginator->param('pageCount'));
	//if($this->Paginator->param('pageCount') >1)
	//{
	//	echo $this->Paginator->prev('« 前のページ ', null, null, array('class' => 'disabled')); //Shows the next and previous links
    
	//	echo " | ".$this->Paginator->numbers()." | "; //Shows the page numbers
    
	//	echo $this->Paginator->next(' 次のページ »　', null, null, array('class' => 'disabled')); //Shows the next and previous links
    //}
	echo "<div class='paging'>";

        echo $this->Paginator->first("初");

        if($this->Paginator->hasPrev()){
            echo $this->Paginator->prev("前");
        }

        echo $this->Paginator->numbers(array('modulus' => 2));

        if($this->Paginator->hasNext()){
            echo $this->Paginator->next("次");
        }

        echo $this->Paginator->last("後");
    
    echo "</div>";
   echo " ".$this->Paginator->counter(array(
    'format' => 'range',
	'separator' => ' /'
	)); // prints X of Y, where X is current page and Y is number of pages
} else {echo "空きデータ";}
?>