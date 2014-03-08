<?php
$paginator = $this->Paginator;

if($lectures){

    echo "<table>";

        echo "<tr>";

            echo "<th>" . $paginator->sort('id', 'ID') . "</th>";
            echo "<th>" . $paginator->sort('name', 'Name') . "</th>";
            echo "<th>" . $paginator->sort('fullname', 'Time') . "</th>";
            echo "<th>" . $paginator->sort("cost", 'Cost') . "</th>";
            echo "<th> Option</th>";
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
                echo "<td>".$item['Lecture']['cost']."</td>";

                echo "<td>";
                $flag = 0;
                $status = 0; // Status de xem hoc hay chua?
                foreach ($list_lectures as $lecture) {
                    if ($lecture['Register']['lecture_id'] == $item['Lecture']['id'])
                    {
                        $flag = 1;
                        $status = $lecture['Register']['status'];
                        break;
                    }
                }
                if($flag == 0)

                 {
                    echo $this->html->link("登録",array 
                    ("action"=>"/register_lecture",'full_base' => true ,$item['Lecture']['id'],"lectures_statistics"),array(),"Gia cua no la ".$item['Lecture']['cost'].". Are you sure?",false); 
                    }
                else
                {
                    if($status == 0 )
                        echo $this->Html->link("勉強", array("controller" => "lectures","action" => "view" ,$item['Lecture']['id']));
                    else 
                        echo $this->Html->link("見直す", array("controller" => "lectures","action" => "view" ,$item['Lecture']['id']));
                }
                echo "</td>";
	     	          
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