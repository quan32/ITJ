<?php
class TeachersController extends AppController{

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('register');

		if($this->Auth->isAuthorized()==false && $this->action!='register'){
			$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
		}
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='teacher')
			return true;
		return false;
	}


	
	public function index (){
	
		$this->set('menu_type','teacher_menu');
		//lay hang so he thong
		$this->loadModel('Constant');
		$constantCost = $this->Constant->findByName('cost');
		$COST = $constantCost['Constant']['value'];

		$constantRate = $this->Constant->findByName('rate');
		$RATE = $constantRate['Constant']['value'];

		$user_id = $this->Auth->user('id');
		// var_dump($user_id);
		$this->loadModel('User');
		$data = $this->User->findById($user_id);

// ------------Lay 5 bai moi nhat---------------------------------
		$this->loadModel('Lecture');
		$this->loadModel('Register');
		$fiveNewestLecture = $this->Lecture->find('all', array(
		    'conditions' => array(
			        'user_id' => $user_id),

		    'order' => 'Lecture.created DESC',
		    'limit' => '5',
		    'recursive' => '-1'
		    		));

// Tinh so hoc sinh dang ki cua cac lecture tren (5 leture moi nhat)
		$i = 0 ;
		foreach ($fiveNewestLecture as $oneLecture) {
			$numberStudent = $this->Register->find('count',
					array(
						'conditions' => array(
					'lecture_id' => $oneLecture['Lecture']['id'])
					)

				);
			
		$fiveNewestLecture[$i]['Lecture']['numberStudent'] = $numberStudent;
		
		$i = $i + 1;
		}

		$this->set("lectures",$fiveNewestLecture);
//
// -----------------------------------------------------------------------


//-------xuan-----------------Tinh so tien + So hoc sinh dang ki--------------------------------
//------------tien + so hoc sinh dang ki thang nay
		$allLecture = $this->Lecture->find('all',array(
		    'conditions' => array(
			        'user_id' => $user_id),
					'recursive' => '-1'
						    ));


		$moneyTemp =  0.0;
		$numberStudent = 0;
		foreach ($allLecture as $oneLecture) {
			$numberTemp = $this->Register->find('count',
					array(
						'conditions' => array(
					'lecture_id' => $oneLecture['Lecture']['id'],
					'MONTH(Register.created)' => date('n')
					)
					)

				);

			
		$moneyTemp = $moneyTemp + $numberTemp * $oneLecture['Lecture']['cost'];
		$numberStudent = $numberStudent + $numberTemp;
			
		}
		$moneyThisMonth = $moneyTemp * 0.6;
		$this->set('numberStudentThisMonth', $numberStudent);
		$this->set('moneyThisMonth',$moneyThisMonth);
//----tien + so hoc sinh dang ki thang truoc---------
	$allLecture = $this->Lecture->find('all',array(
			    'conditions' => array(
				        'user_id' => $user_id),
						'recursive' => '-1'
							    ));


			$moneyTemp =  0.0;
			$numberStudentLastMonth = 0;
			foreach ($allLecture as $oneLecture) {
				$numberTemp = $this->Register->find('count',
						array(
							'conditions' => array(
						'lecture_id' => $oneLecture['Lecture']['id'],
						'MONTH(Register.created)' => date('n',strtotime("-1 month"))
						)
						)

					);

			
			$moneyTemp = $moneyTemp + $numberTemp * $oneLecture['Lecture']['cost'];
			$numberStudentLastMonth = $numberStudentLastMonth + $numberTemp;
				
			}
			$moneyLastMonth = $moneyTemp * 0.6;
			
			$this->set('numberStudentLastMonth', $numberStudentLastMonth);
			$this->set('moneyLastMonth',$moneyLastMonth);
// Tinh tong so tien va hoc sinh hoc bai:
			$allLecture = $this->Lecture->find('all',array(
			    'conditions' => array(
				        'user_id' => $user_id),
						'recursive' => '-1'
							    ));


			$moneyTemp =  0.0;
			$numberStudentLearned = 0;
			foreach ($allLecture as $oneLecture) {
				$numberTemp = $this->Register->find('count',
						array(
							'conditions' => array(
						'lecture_id' => $oneLecture['Lecture']['id'],
						)
						)

					);

			
			$moneyTemp = $moneyTemp + $numberTemp * $oneLecture['Lecture']['cost'];
			$numberStudentLearned = $numberStudentLearned + $numberTemp;
				
			}
			$moneySum = $moneyTemp * 0.6;
			
			$this->set('moneySum', $moneySum);
			$this->set('numberOfAllLearnedStudent',$numberStudentLearned);



	}

	public function info(){
		$this->set('menu_type','teacher_menu');
		$user_id = $this->Auth->user('id');
		$this->loadModel('User');
		$info = $this->User->findById($user_id);
		$this->set("info",$info);
		$this->set("user_id", $user_id);
	}

	public function register($role =null){
		$this->set('menu_type','empty');

		if($this->request->is('post')){
			if($this->request->data['User']['NQ']==1){
				$this->loadModel('User');
				if($this->User->findByUsername($this->request->data['User']['username'])){
					$this->Session->setFlash(__('このアカウントはシステムに存在している。他のアカウントを選んでください'));
					unset($this->request->data['User']['password']);
					// return $this->redirect(array('controller'=>'users','action'=>'login'));
				}else{
					$this->request->data['User']['role']=$role;
					$this->request->data['User']['prevIP']=$this->request->clientIp();
					$this->loadModel('User');
					$this->User->create();
					if($this->User->save($this->request->data)){
						$this->Session->setFlash(__('アカウントはデータベースに保存した'));
						$log="INFO, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 先生として成功して登録した';
						$this->Log->writeLog('new_user.txt',$log);
						return $this->redirect(array('controller'=>'users','action'=>'login'));
					}
					$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 先生として失敗して登録した';
					$this->Log->writeLog('new_user.txt',$log);
					$this->Session->setFlash(__('アカウントはデータベースに保存できなかった。もう一度入力してみてください'));
				}
			}else{
				$this->Session->setFlash(__('ウェブサイトの規則に同意していないから、登録できない'));
				unset($this->request->data['User']['password']);
			}
			
			
		}
	}

	public function edit($id =null){
		$this->set('menu_type','teacher_menu');
		$user_id = $this->Auth->user('id');
		$this->loadModel('User');
		$this->User->id =$user_id;

		if(!$this->User->exists()){
			throw new NotFoundException(__('不当なユーザ'));
		}

		if ($this->request->is('post') || $this->request->is('put')) { 
			if ($this->User->save($this->request->data)) {
		            $this->Session->setFlash(__('ユーザの情報が成功して更新された'));

		          //ghi log :
		          
		           // ghi log
		           $data = $this->User->find('all',array(
		           	'conditions' => array('id' => $user_id),
		           'recursive' => -1)
		           	);
		           	
		           	$date = date('Y-m-d H:i:s');
		            $file = "user_change_info.txt";
		          //"順番", “SUCCESS”, "時間", "ユーザーID", "ユーザー名", "tuoi", “sdt”, “email”, “dia chi”
		            $content =  "\"SUCCESS\","."\"".$date."\","."\"".$data[0]['User']['id']."\","."\"".$data[0]['User']['username']."\",\"基本情報変更\"";
		            
		            $this->Log->writeLog($file,$content);
				//	return $this->redirect(array('action' => 'index')); 
		            return $this->redirect(array('action' => 'info'));
				}
				// ghi log
		           $data = $this->User->find('all',array(
		           	'conditions' => array('id' => $user_id),
		           'recursive' => -1)
		           	);
		           	
		           	$date = date('Y-m-d H:i:s');
		            $file = "user_change_info.txt";
		          //"順番", “SUCCESS”, "時間", "ユーザーID", "ユーザー名", "tuoi", “sdt”, “email”, “dia chi”
		            $content =  "\"SUCCESS\","."\"".$date."\","."\"".$data[0]['User']['id']."\","."\"".$data[0]['User']['username']."\",\"基本情報変更\"";
		            
		            $this->Log->writeLog($file,$content);
		        $this->Session->setFlash(
		            __('エラーが起きてしまった。もう一度してみてください'));
		} else {
		$this->request->data = $this->User->read(null, $id);
		      //  unset($this->request->data['User']['password']);
		    }
	}

	public function changeVerify(){

		$this->set('menu_type','teacher_menu');
		$this->pageTitle = "確認するコード";
		$this->loadModel('User');

		$userId = $this->Auth->user('id');
		$this->User->id = $userId;
		// current user
		$currUser = $this->User->findById($userId);
		// var_dump($currUser);die;

		if(!$this->User->exists()){
			throw new NotFoundException(__('ユーザが無効だ'));
		}

		if($this->request->is(array('post','put'))){
			// hash default sha1
			$passwordHasher = new SimplePasswordHasher();
			$arrPass = $this->request->data;
			// check current password
			if($passwordHasher->check($arrPass['User']['currVerify'],$currUser['User']['verify'])){
				// check new password and confirm password
				if($arrPass['User']['newVerify'] == $arrPass['User']['confVerify']){
					// assign new password to password
					$currUser['User']['verify'] = $arrPass['User']['newVerify'];
					// save user, run function beforeSave() to hash new password
					// $this->User->id = $userId;
					if($this->User->saveField('verify',$arrPass['User']['newVerify'])){
						// write success log to log file 7: change_password.txt
						$log = '"SUCCESS", "'.(string)date('Y-m-d H:i:s').'", "'.(string)$userId.'"';
						$this->Log->writeLog('change_verify.txt',$log);
						$this->Session->setFlash(__('確認するコードが更新された'));
						
						return $this->redirect(array('controller'=>'teachers','action'=>'info'));
						
					}
					else{
						$this->Session->setFlash(__('確認するコードが変更されるのが失敗だ'));
						$log = '"FAIL", "'.(string)date('Y-m-d H:i:s').'", "'.(string)$userId.'", "確認するコードが変更されるのが失敗"';
						$this->Log->writeLog('change_verify.txt',$log);
					}					
				}
				else{
					$this->Session->setFlash(__('確認するコードが間違い'));
					$log = '"FAIL", "'.(string)date('Y-m-d H:i:s').'", "'.(string)$userId.'", "確認するコードが間違い"';
					$this->Log->writeLog('change_password.txt',$log);	
				}				
			}
			else{
				$this->Session->setFlash(__('現在確認するコードが間違い'));
				$log = '"FAIL", "'.(string)date('Y-m-d H:i:s').'", "'.(string)$userId.'", "現在確認するコードが間違い"';
				$this->Log->writeLog('change_verify.txt',$log);	
			}			
		}else{
			$this->request->data = $this->User->read(null, $userId);
		}
	}


	/**
	* function view result of student who do current teacher's test
	* 
	*
	* @author lucnd
	*/

	public function viewResult(){
		$this->set('menu_type','teacher_menu');
		$this->pageTitle = "View test result";

		$userId = $this->Auth->user('id');
		$this->loadModel('User');
		$this->User->id = $userId;


		$this->loadModel('Result');
		$this->loadModel('Lecture');

		$lectures = $this->Lecture->find('all', array('conditions' => array('Lecture.user_id' => $userId)));
		$testId = array();
		//pr($lectures);
		if(!empty($lectures)){
			foreach ($lectures as $lecture) {
				if(!empty($lecture['Test'])){
					foreach ($lecture['Test'] as $test) {
						array_push($testId, $test['id']);
					}
				}
			}

		    $this->paginate = array(
		        'conditions' => array('Result.test_id' => $testId),
		        'limit' => 5,
		        'order' => array('created' => 'desc')
		    );
		}
		else{
			$this->set('results',null);
		}
	}

	/**
	* function view statistic of current teacher
	* 
	* @author lucnd
	*/
	public function statistic(){

		$this->set('menu_type','teacher_menu');
		$this->pageTitle = "Statistic";

		$userId = $this->Auth->user('id');
		$this->loadModel('User');
		$this->User->id = $userId;
		
		$this->loadModel('Lecture');

		$lectures = $this->Lecture->find('all',array('conditions'=>array('Lecture.user_id'=>$userId)));
		$countRegister = 0;
		$countTest = 0;

		foreach ($lectures as $lecture) {
			if($lecture['User']['state'] == 'normal'){
				$countRegister += count($lecture['Register']);
				$countTest += count($lecture['Test']);
			}
		}
		$this->set('countTest',$countTest);
		$this->set('lectures',$lectures);
		$this->set('countRegister',$countRegister);
	}

	public function moneyStatistics()
	{
		//set menu
	    $this->set('menu_type','teacher_menu');
	    // Lay hang he thong
	    $this->loadModel('Constant');
		$constantCost = $this->Constant->findByName('cost');
		$COST = $constantCost['Constant']['value'];

		$constantRate = $this->Constant->findByName('rate');
		$RATE = $constantRate['Constant']['value'];
	    $this->set('COST',$COST);
	    $user_id = $this->Auth->user('id');

	    if($this->request->is('post')) {
	    $month=$this->request->data['Money']['mos'];
	    $year=$this->request->data['Money']['yos'];
	     }
	    else
	    {
	  
	    	$month = date('n');
		 	$year = date('Y');
		 	$this->set('mos',$month);
	   		$this->set('yos',$year);
	    	
	    }
	        //Tinh tien thang da chon

	    $moneyOfTheMonth = $this->calcMoney($month,$year);
	    $this->set('moneyOfTheMonth',$moneyOfTheMonth);
	}

	public function calcMoney($month = null,$year =null)
	{
		//load hang so he thong
		$this->loadModel('Constant');
		$constantCost = $this->Constant->findByName('cost');
		$COST = $constantCost['Constant']['value'];

		$constantRate = $this->Constant->findByName('rate');
		$RATE = $constantRate['Constant']['value'];

		$user_id = $this->Auth->user('id');
		$this->loadModel('Lecture');
		$options = array(
					'joins' => array(
									    array('table' => 'users',
									        'alias' => 'User',
									        'type' => 'inner',
									        'conditions' => array('Lecture.user_id = User.id')
									    ),
									    array(
									    	'table' => 'registers',
									    	'alias' => 'Register',
									    	'type'  => 'inner',
									    	'conditions' => array('Lecture.id = Register.lecture_id')
									    	)
				            
										),
					'conditions' => array(
						'MONTH(Register.created)' => $month,
						'YEAR(Register.created)' => $year,
						'User.id' => $user_id
					),
					'fields' => array( 'count(Register.id) as registerTimes')
					

			);
		$this->Lecture->recursive = -1;
		$data = $this->Lecture->find('all',$options);
		$money = $data[0][0]['registerTimes'] * $COST*(float) ($RATE/100);
		return $money;
		


	}

}


?>