<?php
class Test extends AppModel{
	public $hasOne = 'TsvFile';
	public $hasMany = 'Result';
	public $belongsTo = array(
        'Lecture'
    );

	public function read_file($file){		
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
		$data=array();
		$data['tests'] = $tests;
		$data['test_title'] = $test_title;
		$data['test_sub_title'] = $test_sub_title;
		return $data;
	}
	public function save_result($tests, $result, $user_id){
		//Tinh diem
		$count = 1;
		$tongdiem =0;
		$diem = 0;
		foreach ($tests as $question) {
			if($result[$count]['answer'] == strval($question['ks'])){
				$diem+=$question['point'];
			}
			$count++;
			$tongdiem+=$question['point'];
		}
		$this->Result->create();
		$this->Result->save(array('user_id' => $user_id, 'test_id' => $this->id, 'score' => round($diem/$tongdiem*100,0)));
		return $this->Result->getLastInsertID();
	}
}
?>