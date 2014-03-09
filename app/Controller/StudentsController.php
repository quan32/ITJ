<?php
class StudentsController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('register');
	}

	public function isAuthorized($user){
		// Only teacher can use student's function
		if($user['role']=='student')
			return true;
		return false;

	}


	public function register($role =null){
		$this->set('menu_type','empty');
		 // var_dump($role);

		if($this->request->is('post')){
			$this->loadModel('User');
			if($this->User->findByUsername($this->request->data['User']['username'])){
				$this->Session->setFlash(__('Tai khoan da ton tai, hay chon ten dang nhap khac'));
				unset($this->request->data['User']['password']);
				// return $this->redirect(array('controller'=>'users','action'=>'login'));
			}else{
				$this->request->data['User']['role']=$role;
				$this->request->data['User']['prevIP']=$this->request->clientIp();
				$this->loadModel('User');
				$this->User->create();
				if($this->User->save($this->request->data)){
					$log="INFO, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 学生として成功して登録した';
					$this->Log->writeLog('new_user.txt',$log);
					$this->Session->setFlash(__('The user has been saved'));
					return $this->redirect(array('controller'=>'users','action'=>'login'));
				}

				$this->Session->setFlash(__('The user could no be saved. Please try again'));
				$log="INFO, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 学生として成功して登録した';
				$this->Log->writeLog('new_user.txt',$log);
			}
			
		}
	}

	public function index(){
		$this->set('menu_type','student_menu');
	//lay 5 bai giang moi nhat trong he thong ma user nay dang ki
		$user_id = $this->Auth->user('id');
		$this->loadModel('Register');
		$this->loadModel('User');
		$this->loadModel('Lecture');

		$sql = "SELECT * 
					FROM  `registers` ,  `lectures` ,`users`
					WHERE registers.user_id =".$user_id."
					AND registers.lecture_id = lectures.id
					AND lectures.user_id = users.id
					ORDER BY registers.created DESC
					LIMIT  0 , 5" ;

		$fiveNewestLecture = $this->Lecture->query($sql);
		$this->set('fiveNewestLecture', $fiveNewestLecture);
		
	//lay 5 bai ma hot nhat trong he thong
	//Cac bai co so like nhieu nhat trong vong mot thang ,den thoi diem hien tai

		$options = 	array(
					'joins' => array(
								    array('table' => 'lectures',
								        'alias' => 'Lecture',
								        'type' => 'inner',
								        'conditions' => array('Lecture.id = Favorite.lecture_id')
								    ),
								    array(
								    	'table' => 'users',
								    	'alias' => 'User',
								    	'type'  => 'inner',
								    	'conditions' => array('Lecture.user_id = User.id')
								    	)
			            
									),
					'group'  => 'Lecture.id',
					
			 		'fields' => array('Lecture.id', 'Lecture.name','Lecture.cost','User.fullname','count(Favorite.lecture_id)'),
			 		'order' => 'count(Favorite.lecture_id) DESC',
			 		'conditions' => array('Favorite.created >' => date('Y-m-d H:i:s',strtotime("-1 month")))

				);

			$this->loadModel('Favorite');
			$this->Favorite->recursive = -1;
			$data =  $this->Favorite->find('all',$options);
			$this->set('fiveHotLectures' , $data);
// lay danh sach cac bai ma user nay da dang ki
			$this->loadModel('Register');
			$data_register = $this->Register->find('all',
				array(
					'conditions' => array('Register.user_id' => $user_id),
					'limit' => 100000000000,
					'fields' => array( 'lecture_id','status','user_id')
					)

				);
			$this->set('list_lectures', $data_register);




	//	Hien thi thong tin 5 bai test gan nhat
		$this->loadModel('Result');
		$sql = "SELECT * 
					FROM  `results` ,  `lectures` ,`tests`
					WHERE results.user_id =".$user_id."
					AND results.test_id = tests.id
					AND lectures.id = tests.lecture_id
					ORDER BY results.created DESC
					LIMIT  0 , 5" ;
		$fiveNewestTest = $this->Result->query($sql);
		$this->set('fiveNewestTest',$fiveNewestTest);

	}

	public function top_lecture_hot()
	{
		$this->set('menu_type','student_menu');
		$user_id = $this->Auth->user('id');
		$options = 	array(
					'joins' => array(
								    array('table' => 'lectures',
								        'alias' => 'Lecture',
								        'type' => 'inner',
								        'conditions' => array('Lecture.id = Favorite.lecture_id')
								    ),
								    array(
								    	'table' => 'users',
								    	'alias' => 'User',
								    	'type'  => 'inner',
								    	'conditions' => array('Lecture.user_id = User.id')
								    	)
			            
									),
					'group'  => 'Lecture.id',
					
			 		'fields' => array('Lecture.id', 'Lecture.name','Lecture.cost','User.fullname','count(Favorite.lecture_id)'),
			 		'order' => 'count(Favorite.lecture_id) DESC',
			 		'conditions' => array('Favorite.created >' => date('Y-m-d H:i:s',strtotime("-1 month"))),
			 		'limit' => 10

				);

			$this->loadModel('Favorite');
			$this->Favorite->recursive = -1;
			$this->paginate = $options;
			$data = $this->paginate('Favorite');
			$this->set('hotLectures' , $data);
			// lay danh sach cac bai ma user nay da dang ki
			$this->loadModel('Register');
			$data_register = $this->Register->find('all',
				array(
					'conditions' => array('Register.user_id' => $user_id),
					'limit' => 100000000000,
					'fields' => array( 'lecture_id','status','user_id')
					)

				);
			$this->set('list_lectures', $data_register);
		
	}


	public function view_info(){
		$this->set('menu_type','student_menu');
		$user_id = $this->Auth->user('id');
		$this->loadModel('User');
		$info = $this->User->findById($user_id);
		$this->set("info",$info);
		$this->set("user_id", $user_id);
	}

	
	public function registed_lecture()
	{
		$this->set('menu_type','student_menu');
		$user_id = $this->Auth->User('id');
		$this->loadModel('Register');
	

		$options['joins'] = array(
					    array('table' => 'lectures',
					        'alias' => 'Lecture',
					        'type' => 'inner',
					        'conditions' => array('Lecture.id = Register.lecture_id' )));
			

		$options['conditions'] = array('Register.user_id' => $user_id);
		$options['order'] = array(
					'Register.status ' => 'ASC' 
					);
		$options['fields'] =array('Lecture.id','Lecture.name','Register.created','Lecture.cost','Register.status');
		$options['limit'] = 10;
		$this->Register->recursive = -1;

		$this->paginate = $options;
		$data = $this->paginate('Register');

		$this->set('registedLectures',$data);


	}

	public function register_lecture($param1 = null, $param2 = null)
	{
		$this->set('menu_type','student_menu');
		$user_id = $this->Auth->User('id');
		if($param1 == NULL) $this->redirect(array("action" => 'index') );
		if(!isset($param1)) $this->redirect(array("action" => 'index') );
		if(!isset($param2)) $this->redirect(array("action" => 'index'));

		$data = array(
			'Register' =>array(
					'user_id' => $user_id,
					'lecture_id' => $param1,
					'status'  => 0
				)
			);
		$this->loadModel('Register');
		$this->Register->create();
		if($this->Register->save($data))
		{
			$this->redirect(array("action" => $param2));
		}
		else 
			{
				$this->Session->setFlash(_('システムエラー'));
				$this->redirect(array('action' => 'index'));
			}
		

	}


	public function money_this_month()
	{
		$this->set('menu_type','student_menu');
		$user_id = $this->Auth->user('id');
		$this->loadModel('Register');

		$options['joins'] = array(
					    array('table' => 'lectures',
					        'alias' => 'Lecture',
					        'type' => 'inner',
					        'conditions' => array('Lecture.id = Register.lecture_id' )));
			

		$options['conditions'] = array('Register.user_id' => $user_id);
		$options['order'] = array(
					'Register.created ' => 'ASC' 
					);
		$options['fields'] =array('Lecture.id','Lecture.name','Register.created','Lecture.cost');
		$options['limit'] = 10;
		$this->Register->recursive = -1;

		$this->paginate = $options;
		$data = $this->paginate('Register');

		$sum_money = $this->calc_money();

		$this->set('lecturesOnThisMonth',$data);
		$this->set('sumMoney',$sum_money);

	}

	public function result_statistics()
		{
			$this->set('menu_type','student_menu');
			$user_id = $this->Auth->user('id');
			$this->loadModel('Result');
			$options['joins'] = array(
				array(
					'table' => 'tests',
					'alias' => 'Test',
					'type' => 'inner',
					'conditions' => array('Test.id = Result.test_id')

					),
				array(
					'table' => 'lectures',
					'alias' => 'Lecture',
					'type' => 'inner',
					'conditions' => array('Lecture.id = Test.lecture_id')
					)
				);
			$options['limit'] = 10;
			$options['conditions'] = array('Result.user_id' => $user_id);
			$options['order'] = array('Result.created' => 'ASC');
			$options['fields'] =array('Result.id','Lecture.name','Result.created','Result.score');
			$this->Result->recursive = -1;

			$this->paginate = $options;
			$data = $this->paginate('Result');
		    $this->set('results',$data);
			
		}
	public function lectures_statistics()
	{
		$this->set('menu_type','student_menu');
		$user_id = $this->Auth->user('id');
		$this->loadModel('Lecture');
		$this->loadModel('Register');

		$options=  array(
			'joins' => array(
	
						array(
							'table' => 'users',
							'alias' => 'User',
							'type' => 'inner',
							'conditions' => array("User.id = Lecture.user_id")

							)
					
						),
			'order' => array('Lecture.created' => 'ASC'),
			'limit' => 10,
			'fields' => array('Lecture.id','Lecture.cost','User.fullname','Lecture.name')
		);

		$this->Lecture->recursive = -1;
		$this->paginate = $options;
		$data = $this->paginate('Lecture');
	    $this->set('lectures',$data);


			$data_register = $this->Register->find('all',
				array(
					'conditions' => array('Register.user_id' => $user_id),
					'limit' => 100000000000,
					'fields' => array( 'lecture_id','status','user_id')
					)

				);
			$this->set('list_lectures', $data_register);
	    
	}
		
	public function edit_info($id = null){
		$this->set('menu_type','student_menu');
		$user_id = $this->Auth->user('id');
		$this->loadModel('User');
		$this->User->id =$user_id;

		if(!$this->User->exists()){
			throw new NotFoundException(__('Invalid user'));
		}

		if ($this->request->is('post') || $this->request->is('put')) { 
			$data = $this->request->data['User'] ;
		$data['date_of_birth'] = $data['date_of_birth']['month'].'-'.$data['date_of_birth']['day'].'-'.$data['date_of_birth']['year'];

		//	debug($data); die;
			if ($this->User->save($this->request->data)) {
		            $this->Session->setFlash(__('The info has been updated'));
				//	return $this->redirect(array('action' => 'index')); 
		            return $this->redirect(array('action' => 'view_info'));
				}
		        $this->Session->setFlash(
		            __('Sorry, occur an error. Please, try again.'));
		} else {
		$this->request->data = $this->User->read(null, $id);
		      //  unset($this->request->data['User']['password']);
		    }
	}

	public function calc_money()
	{
		$this->set('menu_type','student_menu');
		//Tinh tien tu dau thang den ngay hien tai
		$user_id = $this->Auth->user('id');
		$this->loadModel('Register');
		$sql = "SELECT SUM( lectures.cost ) AS money
			FROM  `registers` ,  `lectures` 
			WHERE registers.user_id =".$user_id."
			AND registers.lecture_id = lectures.id
			AND MONTH( registers.created ) = EXTRACT( 
			MONTH FROM (NOW()))";
		$data = $this->Register->query($sql);
		return $data;
		


	}
	
	public function del_account()
	{
		$this->set('menu_type','student_menu');
		if($this->request->is('post') || $this->request->is('put')){
					$user_id = $this->Auth->user('id');
					$this->loadModel('User');
					$data = $this->calc_money();
					$money = $data[0][0]['money'];
					if ($money == null||$money == 0) {
						// du dieu kien xoa tai khoan
						$data = array('id' => $user_id, 'state' => 'deleted');
						// This will update Recipe with id 10
						if($this->User->save($data))
						{
							$this->Session->setFlash(_('アカウントは削除した'));
							$this->redirect($this->Auth->logout());
						}
						else 
							{
								$this->Session->setFlash(_('システムエラー'));
								$this->redirect(array('action' => 'index'));
							}
					}
					else
					{
						// de xoa tai khoan ban can thanh toan het tien
						$this->Session->setFlash(__('アカウントを削除できるように、残りの費用を支払っておいてください'));
						$this->redirect(array('action' => 'index'));
					}
			}

		
	}

	/**
	* function change student's password
	*
	* @author lucnd
	*/
	public function changePassword($id =null){
		$userId = $this->Auth->user('id');
		$this->loadModel('User');
		$this->User->id = $userId;
		// current user
		$currUser = $this->User->findById($userId);

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
}
?>