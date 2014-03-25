<?php 
    $this->Paginator->options(array('url' => $this->passedArgs));
?>
<?php echo $this->Form->create('Search',array('action'=>'search'));?>
    <fieldset>
        <legend><?php __('検索');?></legend>
    <?php
		echo $this->Form->input('catagory', array(
			'label' => 'カテゴリ',
			'options' => array(array('label'=>'toan hoc','value'=>'1'),array('label'=>'van hoc','value'=>'2'),array('label'=>'ngoai ngu','value'=>'2')),
			'empty' => '(全部)'));
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
    echo "<th>".$this->Paginator->sort("name","Title");
    echo "<th>".$this->Paginator->sort("description","Description");
    echo "<th>".$this->Paginator->sort("fullname","Teacher");
    echo "<th>".$this->Paginator->sort("Description","Registed Student");
    echo "<th>Register now";
    echo "</tr>";
    
    foreach($posts as $item){
        echo "<tr>";
        echo "<td>".$item['Search']['id']."</td>";
        echo "<td>".$item['Search']['name']."</td>";
        echo "<td>".$item['Search']['description']."</td>";
        echo "<td>".$item['User']['fullname']."</td>";
        echo "<td>".count($item['Register'])."</td>";
        echo "<td>".$this->Html->link("Dang ky ngay", array("controller"))."</td>"; //link to register of Xuan
        echo "</tr>";
    }
    echo "</table>";
    
    //---- Paging 
    echo $this->Paginator->prev('« Previous ', null, null, array('class' => 'disabled')); //Shows the next and previous links
    
    echo " | ".$this->Paginator->numbers()." | "; //Shows the page numbers
    
    echo $this->Paginator->next(' Next »', null, null, array('class' => 'disabled')); //Shows the next and previous links
    
    echo " Page ".$this->Paginator->counter(); // prints X of Y, where X is current page and Y is number of pages
}// else {echo "data empty";}
?>