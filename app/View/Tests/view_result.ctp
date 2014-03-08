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
?>
<h1>Your choice</h1>
<?php
	//Hien thi form with answered choice
	$count = 1;
	foreach ($tests as $question) {
		echo "<br>";
		echo $count.". ".$question['qs']."<br>";
		//hidden field
		echo $this->Form->input($count.'.ks', array('value'=>$question['ks'] ,'type'=>'hidden') );
		echo $this->Form->input($count.'.point', array('value'=>$question['point'] ,'type'=>'hidden') );
		$attributes = array(
		    'legend' => false,
		    'value' => $result[$count]['answer'],
		    'disabled' => true
		);
		echo $this->Form->radio($count.'.answer', $question['s'], $attributes);
		$count++;
	}
?>
<hr>
<h1>Test Result</h1>
<?php
	//Tinh diem
	$count = 1;
	$tongdiem =0;
	$caudung = 0;
	$diem = 0;
	foreach ($tests as $question) {
		if($result[$count]['answer'] == strval($question['ks'])){
			$caudung++;
			$diem+=$question['point'];
		}
		$count++;
		$tongdiem+=$question['point'];
	}
//var_dump($tests);
echo "So cau dung: ".$caudung."/".($count-1)."<br>";
echo "Diem dat duoc: ".$diem."/".$tongdiem." ~ ".round($diem/$tongdiem*10,2)."<br>";
?>