<?php 
    $this->Paginator->options(array('url' => $this->passedArgs));
?>
<?php echo $this->Form->create('User',array('POST','action'=>'index'));?>
    <fieldset>
         <legend><?php __('User Search');?></legend>
    <?php
        echo $this->Form->input('fullname');
        //echo $this->Form->input('description');
        echo $this->Form->submit('Search');
    ?>
    </fieldset>
<?php echo $this->Form->end();?>

<?php
if(!empty($posts)){
    echo "<table>";
    echo "<tr>";
    echo "<th>".$this->Paginator->sort("Id","id");
    echo "<th>".$this->Paginator->sort("fullname","fullname");
    //echo "<th>".$this->Paginator->sort("Description","description");
    echo "</tr>";
    
    foreach($posts as $item){
        echo "<tr>";
        echo "<td>".$item['User']['id']."</td>";
        echo "<td>".$item['User']['fullname']."</td>";
        //echo "<td>".$item['User']['description']."</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    //---- Paging 
    echo $this->Paginator->prev('« Previous ', null, null, array('class' => 'disabled')); //Shows the next and previous links
    
    echo " | ".$this->Paginator->numbers()." | "; //Shows the page numbers
    
    echo $this->Paginator->next(' Next »', null, null, array('class' => 'disabled')); //Shows the next and previous links
    
    echo " Page ".$this->Paginator->counter(); // prints X of Y, where X is current page and Y is number of pages
} else {
	echo "<h2>Data Empty .....</h2>";
}
?>