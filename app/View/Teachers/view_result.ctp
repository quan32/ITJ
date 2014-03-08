
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
			echo '<tr>';
			echo '<td>'.$result['Test']['name'] .'</td>';
			echo '<td>'.$result['User']['username'] .'</td>';
			echo '<td>'.$result['Result']['created'] .'</td>';
			echo '<td>'.$result['Result']['score'] .'</td>';
			echo '</tr>';
		}
        
    echo "</table>";

    // pagination section
    
        echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        echo '</p>
        <div class="paging">';
       
                echo $this->Paginator->prev('< ' . __('prev'), array(), null, array('class' => 'prev disabled'));
                echo $this->Paginator->numbers(array('first'=>2, 'separator' => '','modulus'=>4, 'last'=>2));
                echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
        
        echo '</div>';
    
}

// tell the user there's no records found
else{
    echo "No results found.";
}

?>