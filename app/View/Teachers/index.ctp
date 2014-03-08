
<?php
echo $this->element('teacher_menu');
// 5 bai giang moi tao nhat
if($lectures==NULL){
    echo "<h2>Dada Empty</h2>";
}
else{

    echo "<table>
          <tr>
            <th>Id</th>
            <th>タイトル</th>
            <th>価格</th>
            <th>作成日</th>
            <th>so hoc sinh dang ki</th>
          </tr>";
    foreach($lectures as $lecture){
        echo "<tr>";
        echo "<td>".$lecture['id']."</td>";
        echo "<td>".$lecture['name']."</td>";
        echo "<td>".$lecture['cost']."</td>";
        echo "<td>".$lecture['created']."</td>";
        echo "<td>10</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo $this->Html->link('All', array('controller'=>'lectures', 'action'=>'index'));
//Bang thong tin ve thu nhap
//
// if($data1==NULL){
//     echo "<h2>Dada Empty</h2>";
// }
// else{
    
    
    echo "<br><br><br><br>";
    echo "<table>
        <caption>報酬情報 : </caption>
          <tr>
            <th>id</th>
            <th>Title</th>
          </tr>";
   
        echo "<tr>";
        echo "<td>"."先月"."</td>";
        echo "<td>"."Null"."</td>";
        echo "</tr>";
    
        echo "<tr>";
        echo "<td>"."今月"."</td>";
        echo "<td>"."Null"."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>"."全部"."</td>";
        echo "<td>"."Null"."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>".""."</td>";
        echo " <td>"."<a href=''>All</a>"."</td>";
        echo "</tr>";

//}

//Thong ke so hoc sinh dang ki


    echo "<br><br><br><br>";
    echo "<table>
        <caption>登録した学生の人数 : </caption>

          <tr>
            <th>id</th>
            <th>Title</th>
          </tr>";
   
        echo "<tr>";
        echo "<td>"."先月"."</td>";
        echo "<td>"."Null"."</td>";
        echo "</tr>";
    
        echo "<tr>";
        echo "<td>"."今月"."</td>";
        echo "<td>"."Null"."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>"."全部"."</td>";
        echo "<td>"."Null"."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>".""."</td>";
        echo " <td>"."<a href=''>All</a>"."</td>";
        echo "</tr>";


?>

