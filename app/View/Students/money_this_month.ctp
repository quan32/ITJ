<?php
$paginator = $this->Paginator;
if($sumMoney)
{

    echo "今月の学費の合計 : ".$sumMoney[0][0]['money']." VND";
}
else
    echo "Empty data";

if($lecturesOnThisMonth){

    echo "<table>";

        echo "<tr>";

            echo "<th>" . $paginator->sort('id', 'ID') . "</th>";
            echo "<th>" . $paginator->sort('name', 'タイトル') . "</th>";
            echo "<th>" . $paginator->sort('created', '時間') . "</th>";
            echo "<th>" . $paginator->sort("cost", 'コスト') . "</th>";
            echo "</tr>";
        

        foreach( $lecturesOnThisMonth as $item ){

                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['Register']['created']."</td>";
                echo "<td>".$item['Lecture']['cost']."</td>";
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