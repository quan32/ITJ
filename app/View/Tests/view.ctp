<meta http-equiv="Content-Type" content="text/html; charset=SJIS">
<?php
	$file = UPLOAD_FOLDER.DS.$test['File']['name'];
	$f = fopen($file, "r");
	
	$tests=array();
	$test_title = substr(fgets($f, 1000),10);
	$test_sub_title = substr(fgets($f, 1000),13);
	
	while ( $line = fgets($f, 1000) ) {
		$line_first_char = substr($line, 0, 1);
		if($line_first_char == '#') continue; //bo qua comments
		if($line_first_char == 'Q'){
			$i = substr($line,2,1);
			$type_first_char = substr($line,5,1);
			if($type_first_char == 'Q'){
				$tests[$i]['qs'] = substr($line,8);
			}
			if($type_first_char == 'S'){
				$tests[$i]['s'][] = substr($line,10);
			}
			if($type_first_char == 'K'){
				$tests[$i]['ks'] = substr($line,10,1) -1;
				$tests[$i]['point'] = substr($line,13,2);
			}
		}
	}

	//Hien thi form
	echo $this->Form->create('Questions', array('url' => array('controller' => 'tests', 'action' => 'view_result')));
	echo $this->Form->input('test_id', array('value'=>$test_id,'type'=>'hidden') );
	$count = 1;
	foreach ($tests as $question) {
		echo "<br>";
		echo $count.". ".$question['qs']."<br>";
		//answer choice
		$attributes = array(
		    'legend' => false,
		    //'checked'=> ($foo == "pro") ? FALSE : TRUE,
		);
		echo $this->Form->radio($count.'.answer', $question['s'], $attributes);

		$count++;
	}
	echo $this->Form->end(array('label'=>'Submit'));
?>