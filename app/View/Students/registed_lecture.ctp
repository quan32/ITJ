<?php
$paginator = $this->Paginator;

if($registedLectures){

    echo "<table>";

        echo "<tr>";

            echo "<th>" . $paginator->sort('id', 'ID') . "</th>";
            echo "<th>" . $paginator->sort('name', 'Name') . "</th>";
            echo "<th>" . $paginator->sort('created', 'Time') . "</th>";
            echo "<th>" . $paginator->sort("cost", 'Cost') . "</th>";
            echo "<th>" . $paginator->sort('status', 'Option') . "</th>";
        echo "</tr>";
        

        foreach( $registedLectures as $item ){

                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['Register']['created']."</td>";
                echo "<td>".$item['Lecture']['cost']."</td>";
              $lastWeek = time() - 7*24*60*60;

              if(strtotime($item['Register']['created']) >= $lastWeek)
              {
	                if($item['Register']['status'] == 0)
	                	echo "<td>".$this->Html->link("学ぶ",array("controller" => "lectures", "action" => "view",$item['Lecture']['id']))."</td>";
	                else if ($item ['Resgister']['status'] ==1)
	                	echo "<td>".$this->Html->link("見直す",array("controller" => "lectures", "action" => "view",$item['Lecture']['id']))."</td>";
	      
	          }
	          else {
	          	echo $this->html->link("登録",array 
                    ("action"=>"/register_lecture",'full_base' => true ,$item['Lecture']['id'],"registed_lecture"),array(),"Gia cua no la ".$item['Lecture']['cost'].". Are you sure?",false);
	          }
	            echo "</tr>";
        }
        
    echo "</table>";

    echo "<div class='paging'>";

        echo $paginator->first("First");

        if($paginator->hasPrev()){
            echo $paginator->prev("Prev");
        }

        echo $paginator->numbers(array('modulus' => 2));

        if($paginator->hasNext()){
            echo $paginator->next("Next");
        }

        echo $paginator->last("Last");
    
    echo "</div>";
    
}

else{
    echo " Data empty";
}


?>