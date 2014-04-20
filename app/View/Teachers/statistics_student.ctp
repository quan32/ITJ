<h1>学生の課金状況</h1><br />
<?php
$paginator = $this->Paginator;

if($registedLectures){
echo '<h2>学生の情報 : </h2><br/>';
echo '<table style="border:1px dotted #4c66a4!important;
        margin:10px;" >';

             echo "<tr>";
            echo "<td>ユーザー</td>";
            echo "<td>".$registedLectures[0]['User']['username']."</td>";
            echo "</tr>";
       
            echo "<tr>";
            echo "<td>氏名</td>";
            echo "<td>".$registedLectures[0]['User']['fullname']."</td>";
            echo "</tr>";
  
            echo "<tr>";
            echo "<td>住所</td>";
            echo "<td>".$registedLectures[0]['User']['address']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>メール</td>";
            echo "<td>".$registedLectures[0]['User']['mail']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>電話番号</td>";
            echo "<td>".$registedLectures[0]['User']['mobile_No']."</td>";
            echo "</tr>";

            echo "</table>";

            echo "<br>";
            echo "<br>";

//-----------
            echo '<h2>課金状況 : </h2><br/>';
            echo  '<h3>学生の支払った金額の'.$RATE.'％を報酬として受け取ります。</h3>';
            echo '<h3>全部 : '.$sumMoney.'VND</h3><br/>';
            echo '<h3>払わない : '.$notPayedMoney.'VND</h3><br/>';
            echo '<h3>払った : '.$payedMoney.'VND</h3><br/>';
            
    echo "<table>";

        echo "<tr>";
            echo "<th>" . $paginator->sort('Lecture.id', '講義ID') . "</th>";
            echo "<th>" . $paginator->sort('Lecture.name', 'タイトル') . "</th>";
            echo "<th>" . $paginator->sort('Register.created', '登録の時間') . "</th>";
            echo "<th>コスト</th>";
            echo "<th>課金状況</th>";
        echo "</tr>";
        

        foreach( $registedLectures as $item ){

                echo "<tr>";
                echo "<td>".$item['Lecture']['id']."</td>";
                echo "<td>".$item['Lecture']['name']."</td>";
                echo "<td>".$item['Register']['created']."</td>";
                echo "<td>".$COST."VND</td>";
                if($item['notPayed'] == 1)
                    echo "<td>払わない</td>";
                else 
                    echo "<td>払った</td>";
                              
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
        echo $this->Paginator->counter('ページ {:page} / {:pages}');


    
    echo "</div>";
    
}

else{
    echo " 空きデータ";
}


?>
