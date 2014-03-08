<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class TeachersController extends AppController{

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('register');
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='teacher')
			return true;
		return false;

	}


	
	public function index (){
	

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
		$user_id = $this->Auth->user('id');
		$this->loadModel('User');
		$info = $this->User->findById($user_id);
		$this->set("info",$info);
		$this->set("user_id", $user_id);
	}

	public function register($role =null){

		if($this->request->is('post')){
			$this->request->data['User']['role']=$role;
			$this->request->data['User']['prevIP']=$this->request->clientIp();
			$this->loadModel('User');
			$this->User->create();
			if($this->User->save($this->request->data)){
				$this->Session->setFlash(__('The user has been saved'));
				return $this->redirect(array('controller'=>'users','action'=>'login'));
			}

			$this->Session->setFlash(__('The user could no be saved. Please try again'));
		}
	}

	public function edit($id =null){

		$user_id = $this->Auth->user('id');
		$this->loadModel('User');
		$this->User->id =$user_id;

		if(!$this->User->exists()){
			throw new NotFoundException(__('Invalid user'));
		}

		if ($this->request->is('post') || $this->request->is('put')) { 
			if ($this->User->save($this->request->data)) {
		            $this->Session->setFlash(__('The info has been updated'));
				//	return $this->redirect(array('action' => 'index')); 
		            return $this->redirect(array('action' => 'info'));
				}
		        $this->Session->setFlash(
		            __('Sorry, occur an error. Please, try again.'));
		} else {
		$this->request->data = $this->User->read(null, $id);
		      //  unset($this->request->data['User']['password']);
		    }
	}

	/**
	* function change teacher's password
	*
	* @author lucnd
	*/
	public function changePassword($id =null){
		$this->pageTitle = "Change password";

		$userId = $this->Auth->user('id');
		$this->loadModel('User');
		$this->User->id = $userId;
		// current user
		$currUser = $this->User->findById($userId);

		if(!$this->User->exists()){
			throw new NotFoundException(__('Invalid user'));
		}

		if($this->request->is(array('post','put'))){
			// hash default sha1
			$passwordHasher = new SimplePasswordHasher();
			$arrPass = $this->request->data;
			// check current password
			if($passwordHasher->check($arrPass['User']['currPassword'],$currUser['User']['password'])){
				// check new password and confirm password
				if($arrPass['User']['newPassword'] == $arrPass['User']['confPassword']){
					// assign new password to password
					$currUser['User']['password'] = $arrPass['User']['newPassword'];
					// save user, run function beforeSave() to hash new password
					if($this->User->save($currUser)){
						$this->Session->setFlash(__('Password has been updated'));
						return $this->redirect(array('action' => 'info'));
					}
					$this->Session->setFlash(__('Change password fail'));
				}
				$this->Session->setFlash(__('Confirm password fail'));
			}
			$this->Session->setFlash(__('Current password fail'));
		}else{
			$this->request->data = $this->User->read(null, $id);
		}
	}

	/**
	* function view result of student who do current teacher's test
	* 
	*
	* @author lucnd
	*/
	public function viewResult($id = null){
		$this->pageTitle = "View test result";

		$userId = $this->Auth->user('id');
		$this->loadModel('User');
		$this->User->id = $userId;

		$this->loadModel('Test');
		$this->loadModel('Result');

		
		$tests = $this->Test->find('all',array('conditions'=>array('Test.user_id'=>$userId)));
		$studs = $this->User->find('all',array('conditions'=>array('User.role'=>'student')));
		$testId = array();
		if(!empty($tests)){
			foreach ($tests as $test) {
				array_push($testId, $test['Test']['id']);
			}

		    $this->paginate = array(
		        'conditions' => array('Result.test_id' => $testId),
		        'limit' => 5,
		        'order' => array('id' => 'desc')
		    );
		    
		    $results = $this->paginate('Result');  
		    
			$this->set('results',$results);
			//pr($results);
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
		$this->pageTitle = "Statistic";

		$userId = $this->Auth->user('id');
		$this->loadModel('User');
		$this->User->id = $userId;
		$this->loadModel('Test');
		$this->loadModel('Lecture');

		$tests = $this->Test->find('all',array('conditions'=>array('Test.user_id'=>$userId)));
		$lectures = $this->Lecture->find('all',array('conditions'=>array('Lecture.user_id'=>$userId)));
		$countRegister = 0;
		//pr($lectures);
		// pr($tests);
		foreach ($lectures as $lecture) {
			$countRegister += count($lecture['Register']);
		}
		$this->set('tests',$tests);
		$this->set('lectures',$lectures);
		$this->set('countRegister',$countRegister);
	}
}
?>