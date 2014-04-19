<?php
class Test extends AppModel{
	public $hasOne = 'TsvFile';
	public $hasMany = 'Result';
	public $belongsTo = array(
        'Lecture'
    );

	public function read_file($file){		
		$f = fopen($file, "r");
		$data=array();
		$tests=array();
		$data['errors'] = array();
		$test_title = '';
		$test_sub_title = '';
		$last_line = '';
		
		while ( $line = fgets($f, 1000) ) {
			$line_first_char = substr($line, 0, 1);
			if($line_first_char == '#') continue; //bo qua comments o dau
			//bo qua comment o trong cau
			if(strpos($line, '#')!==false){
				$sharp_index = strpos($line, '#');
				$line = substr($line, 0, ($sharp_index-1));
			}
			if(strpos($line, 'TestTitle')!==false){
				$test_title = mb_convert_encoding(substr($line,10),"UTF-8", "UTF-8");
			}

			if(strpos($line, 'TestSubTitle')!==false){
				$test_sub_title = mb_convert_encoding(substr($line,13),"UTF-8", "UTF-8");
			}

			if($line_first_char == 'Q'){
				//check i la 1 chu so hay 2 chu so luu vao $index =0 | 1 => moi vi tri + them voi index
				$extra_index = (substr($line,3,1) == ')') ? 0 : 1;
				//$extra_index = 0;
				$i = substr($line,2,$extra_index + 1);
				$type_first_char = substr($line,$extra_index + 5,1);
				if($type_first_char == 'Q'){
					$tests[$i]['qs'] = mb_convert_encoding(substr($line,$extra_index + 8), "UTF-8", "UTF-8");
				}
				if($type_first_char == 'S'){
					$tests[$i]['s'][] = mb_convert_encoding(substr($line,$extra_index + 10), "UTF-8", "UTF-8");
				}
				if($type_first_char == 'K'){
					$tests[$i]['ks'] = substr($line,$extra_index + 10,1) -1;
					//check loi xem ks co trong s khong
					$max_answer_index = count($tests[$i]['s'])-1;
					if($tests[$i]['ks'] <0 || $tests[$i]['ks']>$max_answer_index)
						$data['errors'][] = "Loi phan Ks o cau so ".($i);
					$tests[$i]['point'] = substr($line,$extra_index + 13,2);
				}
			}
			if($line_first_char!='	') $last_line = $line;
		}
		//check loi ko ket thuc voi End
		if(substr($last_line,0,3) != 'End')
			$data['errors'][] = "loi khong ket thu voi End";
		//var_dump($tests['errors']);die;
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