<h1>学費統計 </h1>

<?php 


echo $this->Form->create('Money'); 

echo "時間 :  ";
if( isset($mos) && isset($yos))
{
echo $this->Form->month('mos', array('monthNames' => false,'value' => $mos,'empty'=>false))."   ";
echo $this->Form->year('yos', 2013, date('Y'), array('value' => $yos,'empty'=>false ));
}
else
{
echo $this->Form->month('mos', array('monthNames' => false,'empty'=>false));
echo $this->Form->year('yos', 2013, date('Y'),array('empty'=>false));	
}
echo $this->Form->end(array('label'=>'表現'));

//Hien so tien mua bai giang cua thang da chon
if(isset($moneyOfTheMonth))
{

if($moneyOfTheMonth > 0)
    echo "<br /><h3>学費の合計 : ".$moneyOfTheMonth." VND</h3>";
else
	if($moneyOfTheMonth == null)
	echo "この月に、登録した講義がありません";
}


//phan trang cac bai da dang ki cua thang da chon



if(isset($lecturesOfTheMonth)){

	echo '<h3>詳しい情報の一覧表:</h3>';

	$paginator = $this->Paginator;

    echo "<table>";

        echo "<tr>";

            echo "<th>" . $paginator->sort('Lecture.id', 'ID') . "</th>";
            echo "<th>" . $paginator->sort('Lecture.name', 'タイトル') . "</th>";
            echo "<th>" . $paginator->sort('Register.created', '時間') . "</th>";
            echo "<th>詳しく</th>";
            echo "<th>コスト</th>";
            echo "</tr>";
        

        foreach( $lecturesOfTheMonth as $item ){

                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['title']."</td>";
                echo "<td>".$item['Register']['time']."</td>";
                 echo "<td>".$this->Html->link('見る',array('controller' => 'Students','action' => 'detailLecture',$item['Lecture']['id'], 'moneyStatistics'));
                echo "<td>".$COST."VND</td>";
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



?>