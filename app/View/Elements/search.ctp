<?php 
    $this->Paginator->options(array('url' => $this->passedArgs));
?>
<?php echo $this->Form->create('Search',array('action'=>'search'));?>
    <fieldset>
        <legend><?php __('検索');?></legend>
        <table class="search_box">
            <tr>
                <td class="td1"><?php echo $this->Form->input('keyword',array('label'=>'')); ?></td>
                <td class="td2"><?php echo $this->Form->input('catagory', array('label'=>'','options'=>$catagory)); ?></td>
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