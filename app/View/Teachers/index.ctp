<?php
echo $this->element('search');
// 5 bai giang moi tao nhat
if($lectures==NULL){
    echo "<h2>空きデータ</h2>";
}
else{

    echo "<table>
    <caption>最新の講義 : </caption>

          <tr>
            <th>Id</th>
            <th>タイトル</th>
            <th>価格</th>
            <th>作成日</th>
            <th>登録した学生の数</th>
          </tr>";
        foreach($lectures as $lecture){
        echo "<tr>";
        echo "<td>".$lecture['Lecture']['id']."</td>";
        echo "<td>".$lecture['Lecture']['name']."</td>";
        echo "<td>".$COST."VND</td>";
        echo "<td>".$lecture['Lecture']['created']."</td>";
        echo "<td>".$lecture['Lecture']['numberStudent']."</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
