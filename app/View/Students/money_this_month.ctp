<h1>学費情報</h1>
<?php
$paginator = $this->Paginator;
if($sumMoney)
{

    echo "<h2>今月の学費の合計 : ".$sumMoney[0][0]['money']." VND</h2>";
}
else
    echo "空きデータ";

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

        echo $paginator->first("初");

        if($paginator->hasPrev()){
            echo $paginator->prev("前");
        }

        echo $paginator->numbers(array('modulus' => 2));

        if($paginator->hasNext()){
            echo $paginator->next("次");
        }

        echo $paginator->last("後");
    
    echo "</div>";
    
}

else{
    echo " 空きデータ";
}


?>