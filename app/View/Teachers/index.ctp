
<?php
echo $this->element('search');
// 5 bai giang moi tao nhat
if($lectures==NULL){
    echo "<h2>Dada Empty</h2>";
}
else{

    echo "<table>
    <caption>登録した学生の人数 : </caption>

          <tr>
            <th>Id</th>
            <th>タイトル</th>
            <th>価格</th>
            <th>作成日</th>
            <th>so hoc sinh dang ki</th>
          </tr>";
        foreach($lectures as $lecture){
        echo "<tr>";
        echo "<td>".$lecture['Lecture']['id']."</td>";
        echo "<td>".$lecture['Lecture']['name']."</td>";
        echo "<td>".$lecture['Lecture']['cost']."</td>";
        echo "<td>".$lecture['Lecture']['created']."</td>";
        echo "<td>".$lecture['Lecture']['numberStudent']."</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo $this->Html->link('All', array('controller'=>'lectures', 'action'=>'index'));
//Bang thong tin ve thu nhap

if($moneyThisMonth==NULL){
    $moneyThisMonth = 0 ;
 }
 if($moneyLastMonth == Null)
    $moneyLastMonth = 0;
if(!isset($moneySum)) $moneySum = 0;
   
    
    echo "<br><br><br><br>";
    echo "<table>
        <caption>報酬情報 : </caption>
          <tr>
            <th>Time</th>
            <th>Money</th>
          </tr>";
   
        echo "<tr>";
        echo "<td>"."先月"."</td>";
        echo "<td>".$moneyLastMonth."</td>";
        echo "</tr>";
    
        echo "<tr>";
        echo "<td>"."今月"."</td>";
        echo "<td>".$moneyThisMonth."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>"."全部"."</td>";
        echo "<td>".$moneySum."</td>";
        echo "</tr>";
        echo "</table>";



//Thong ke so hoc sinh dang ki

if($numberStudentThisMonth == Null) $numberStudentThisMonth = 0;
if($numberStudentLastMonth == Null) $numberStudentLastMonth = 0;
if($numberOfAllLearnedStudent == Null) $numberOfAllLearnedStudent = 0;

    echo "<br><br><br>";
    echo "<table>
        <caption>登録した学生の人数 : </caption> 
        <tr>
            <th>Time</th>
            <th>Value</th>
        </tr>";
        
   
        echo "<tr>";
        echo "<td>"."先月"."</td>";
        echo "<td>".$numberStudentLastMonth."</td>";
        echo "</tr>";
    
        echo "<tr>";
        echo "<td>"."今月"."</td>";
        echo "<td>".$numberStudentThisMonth."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>"."全部"."</td>";
        echo "<td>".$numberOfAllLearnedStudent."</td>";
        echo "</tr>";
        echo "</table>";
        


?>
