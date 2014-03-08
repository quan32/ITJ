<?php
$paginator = $this->Paginator;
if($results)
{
    echo "<table>";

        echo "<tr>";

            echo "<th>" . $paginator->sort('id', 'ID') . "</th>";
            echo "<th>" . $paginator->sort('name', 'Name') . "</th>";
            echo "<th>" . $paginator->sort('created', 'Time') . "</th>";
            echo "<th>" . $paginator->sort("score", 'Cost') . "</th>";
            echo "<th> Option</th>";

        echo "</tr>";
        

        foreach( $results as $item ){

                echo "<tr>";
                echo "<td>".$item['Result']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['Result']['created']."</td>";
                echo "<td>".$item['Result']['score']."</td>";
                echo "<td>".$this->Html->link("見直す", array("controller" => "tests", "action" => "view",))."</td>";
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