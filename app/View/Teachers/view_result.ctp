<h1>テストの結果を見る</h1>


<!-- *************************************************** -->

<?php

$paginator = $this->Paginator;

if(!empty($results)){

    //creating our table
    echo '<table>
		<tr>
			<th>テスト名</th>
			<th>学生名</th>
			<th>タイム</th>
			<th>結果</th>
		</tr>
			';
        
        // loop through the result's records
        foreach ($results as $result) {
            if($result['User']['state'] == 'normal'){
                echo '<tr>';
                echo '<td>'.$result['Test']['name'] .'</td>';
                echo '<td>'.$result['User']['username'] .'</td>';
                echo '<td>'.$result['Result']['created'] .'</td>';
                echo '<td>'.$result['Result']['score'] .'</td>';
                echo '</tr>';
            }
		}
        
    echo "</table>";

    // pagination section
    
        echo $this->Paginator->counter(array(
        'format' => __('{:pages}の{:page}ページ、{:count}の{:current}レーコドでレーコド{:start}からレーコド{:end}までを表示する')
        ));
        echo '</p>
        <div class="paging">';
       
                echo $this->Paginator->prev('< ' . __('前へ'), array(), null, array('class' => 'prev disabled'));
                echo $this->Paginator->numbers(array('first'=>2, 'separator' => '','modulus'=>4, 'last'=>2));
                echo $this->Paginator->next(__('次へ') . ' >', array(), null, array('class' => 'next disabled'));
        
        echo '</div>';
    
}

// tell the user there's no records found
else{
    echo "結果がない";
}
?>