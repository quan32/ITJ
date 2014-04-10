<?php
if($lectureName != null)
{

echo '<h1>「'.$lectureName.'」という講義:</h1><br>';
if($numRegister == 0) $percent = 0;
else
	$percent = 100*$numLike/$numRegister;
echo '<h2>学生が受講した:</h2>
				<table>
				<tr>
					<td>参照の数</td>
					<td>登録の数</td>
					<td>「いいね」の数</td>
					<td>「いいね」/登録者</td>
				</tr>
				<tr>
					<td>'.$referenceTimes.'</td>
					<td>'.$numRegister.'</td>
					<td>'.$numLike .'</td>
					<td>'.$percent.'%</td>
				</tr>
				</table>';


if(isset($users))
{
	if($users != null)
	{
		$paginator = $this->Paginator;
			echo '<h2>学生が受講した:</h2>
				<table>
				<tr>
					<th>ユーザ名</th>
					<th>氏名</th>
					<th>Role</th>
					<th>電話番号</th>
					<th>電話番号</th>
					<th>登録の数</th>
				</tr>';

			
			foreach ($users as $user) {
				echo '<tr>';
					echo '<td>'.$user["User"]["username"].'</td>';
					echo '<td>'.$user["User"]["fullname"].'</td>';
					echo '<td>'.$user["User"]["role"].'</td>';
					echo '<td>'.$user["User"]["mail"].'</td>';
					echo '<td>'.$user["User"]["mobile_No"].'</td>';
					echo '<td>'.$user[0]['registerTimes'].'</td>';
				echo '</tr>';
			}

		echo '</table> ';
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

	else
	{
		echo 'この講義は誰にも受講しません。';
	}
}
}

?>