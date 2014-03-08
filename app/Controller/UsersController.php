<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('CakeTime', 'Utility');
class UsersController extends AppController{

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('login', 'role', 'verify1','verify2');
	}
	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='student' || $user['role']=='teacher' || $user['role']=='manager')
			return true;
		return false;
	}


	public function vidu(){
		if($this->request->is('post')){
			debug($this->request->data);
		}
		
	}
	public function index(){
		// $this->User->recursive = 0;
		// $this->set('users', $this->paginate());
	}
	


	public function view($id = null){
		$this->User->id = $id;
		if(!$this->User->exists())
			throw new NotFoundException(__('Invalid user'));

		$this->set('user', $this->User->read(null, $id));
	}

	public function edit($id = null){
		$this->User->id =$id;
		if(!$this->User->exists()){
			throw new NotFoundException(__('Invalid user'));
		}

		if ($this->request->is('post') || $this->request->is('put')) { 
			if ($this->User->save($this->request->data)) {
		            $this->Session->setFlash(__('The user has been saved'));
					return $this->redirect(array('action' => 'index')); 
				}
		        $this->Session->setFlash(
		            __('The user could not be saved. Please, try again.'));
		} else {
		$this->request->data = $this->User->read(null, $id);
		        unset($this->request->data['User']['password']);
		    }

	}

	public function delete($id =null){
		// if($this->request->is('post')){
			// debug($id);die;

			$this->User->id = $id;
			if(!$this->User->exists())
				throw new NotFoundException(__('Nguoi dung nay chua ton tai'));

			if($this->User->saveField('state','deleted')){
				$this->Session->setFlash(__('User deleted'));
				if($this->Auth->user('role')!='manager')
					return $this->redirect($this->Auth->logout());
				return $this->redirect(array('controller'=>'manages','action'=>'index'));
			}
			$this->Session->setFlash(__('User was not deleted'));
				if($this->Auth->user('role')=='teacher')
					return $this->redirect(array('controller'=>'teachers','action'=>'index'));
				elseif($this->Auth->user('role')=='student')
					return $this->redirect(array('controller'=>'students','action'=>'index'));
				elseif($this->Auth->user('role')=='manager')
					return $this->redirect(array('controller'=>'manages','action'=>'index'));

			// }
	}

	public function login(){
		// $this->layout='ajax';
		$max=3;//so lan dang nhap that bai thi bi khoa tai khoan tam thoi
		$time=7200;//7200(s)=2(h)

		// Check session
		if($this->Auth->loggedIN() && $this->Auth->user('state')=="normal"){
			if($this->Auth->user('role')=='manager')
					return $this->redirect(array('controller'=>'manages','action'=>'index'));
				elseif($this->Auth->user('role')=='teacher')
					return $this->redirect(array('controller'=>'teachers','action'=>'index'));
				else
					return $this->redirect(array('controllers'=>'students','action'=>'index'));
			}

		// If there is not session -> check usrname & password -> create session

		if($this->request->is('post')){

			$IP = $this->request->clientIp();

			if($user=$this->User->findByUsername($this->request->data['User']['username'])){
				$passwordHasher = new SimplePasswordHasher();
				$password = $passwordHasher->hash($this->request->data['User']['password']);
				
				//Check user's state
				if($password == $user['User']['password']){
					if($user['User']['role']=='teacher'){
						if($user['User']['state']=='new'){//Trang thai moi dang nhap dang cho xac nhan
							$this->Session->setFlash(__('Tai khoan chua duoc quan tri chap nhan, hay quay lai sau'));
							return $this->redirect(array('action'=>'login'));
						}elseif ($user['User']['state']=='blocked') {//Trang thai bi khoa tam thoi do qua 3 lan dang nhap that bai
							$time_now = intval(strtotime(date('H:i:s d-m-Y')));
  							$temp_time = intval(strtotime($user['User']['modified']));
  							$distance_time = $time_now - $temp_time;

							if($distance_time > $time){
								$this->User->id=$user['User']['id'];
								$this->User->saveField('failedNo',0);
								$this->Session->setFlash(__('Tai khoan cua ban vua qua khoi thoi gian khoa tam thoi, hay nhap verify code'));
								return $this->redirect(array('controller'=>'users','action'=>'verify1',$user['User']['id']));
							}else{
								$this->Session->setFlash(__('Tai khoan dang tam thoi bi khoa hay tro lai sau'));
							return $this->redirect(array('action'=>'login'));
							}			
						}elseif($user['User']['state']=='deleted'){//Tai khoan da bi khoa
							$this->Session->setFlash(__('Tai khoan da bi xoa, hay tao tai khoan moi'));
							return $this->redirect(array('action'=>'login'));
						}elseif($user['User']['prevIP']!=$IP && $user['User']['prevIP']!=null){//Dia chi Ip su dung khac voi lan su dung truoc
							$this->Session->setFlash(__('Dia chi IP ban dang su dung khac dia chi IP su dung lan truoc, hay nhap ma xac thuc'));
							return $this->redirect(array('controller'=>'users','action'=>'verify2',$user['User']['id'], $IP));
							}
						
					}elseif ($user['User']['role']=='student') {
						if($user['User']['state']=='new'){//Trang thai moi dang nhap dang cho xac nhan
							$this->Session->setFlash(__('Tai khoan chua duoc quan tri chap nhan, hay quay lai sau'));
							return $this->redirect(array('action'=>'login'));
						}elseif ($user['User']['state']=='blocked') {//Trang thai bi khoa tam thoi do qua 3 lan dang nhap that bai
							$time_now = intval(strtotime(date('H:i:s d-m-Y')));
  							$temp_time = intval(strtotime($user['User']['modified']));
  							$distance_time = $time_now - $temp_time;

							if($distance_time > $time){
								$this->User->id=$user['User']['id'];
								$this->User->saveField('failedNo',0);
								$this->Session->setFlash(__('Tai khoan cua ban vua qua khoi thoi gian khoa tam thoi, hay nhap dang nhap lai'));
								return $this->redirect(array('action'=>'login'));
							}else{
								$this->Session->setFlash(__('Tai khoan dang tam thoi bi khoa hay tro lai sau'));
								return $this->redirect(array('action'=>'login'));
							}			
						}elseif($user['User']['state']=='deleted'){//Tai khoan da bi khoa
							$this->Session->setFlash(__('Tai khoan da bi xoa, hay tao tai khoan moi'));
							return $this->redirect(array('action'=>'login'));
						}
					}else{//Xu ly dang nhap cho manager
						$count=0;

						// debug($user);die;
						foreach ($user['Ip'] as $ip) {
							if($ip['ip']==$IP)
								$count++;
						}
						if($count==0){
							$this->Session->setFlash(__('Dia chi IP khong dung'));
							return $this->redirect(array('action'=>'login'));
						}
					}
					
				}

				if($this->Auth->login()){
					$this->Session->setFlash('Your are logged in');
					
					if($this->Auth->user('role')=='manager')
						return $this->redirect(array('controller'=>'manages','action'=>'index'));
					elseif($this->Auth->user('role')=='teacher')
						return $this->redirect(array('controller'=>'teachers','action'=>'index'));
					else
						return $this->redirect(array('controller'=>'students','action'=>'index'));
					}
				else{
					$this->Session->setFlash(__('Invalid username or password, try again'));

					if($user['User']['failedNo'] == $max){
						$this->Session->setFlash(__('Ban da dang nhap that bai qua 3 lan.
							Tai khoan cua ban se bi khoa tam thoi trong thoi gian 2(h)'));

						$this->User->id=$user['User']['id'];
						$this->User->saveField('state','blocked');
						$this->User->saveField('failedNo',0);
						}else{
							$this->User->id=$user['User']['id'];
							$failedNo=$user['User']['failedNo']+1;
							$this->User->saveField('failedNo', $failedNo);
						}
					}
					

					
				}else{
					$this->Session->setFlash(__('Your account is not exist! Register new account, please'));
					}	
		}
	}

	public function verify1($id =null){
		// $this->layout='ajax';
		if($this->request->is('post')){
			$user= $this->User->findById($id);
			if($user['User']['verify']==$this->request->data['User']['verify']){

				$this->Session->setFlash(__('The verify code is correct'));
				$this->User->id=$id;
				$this->User->saveField('state','normal');
				return $this->redirect(array('controller'=>'users','action'=>'login'));	
			}else{
				$this->Session->setFlash(__('The verify code is incorrect'));
			}
		}
	}

	public function verify2($id =null, $IP =null){
		// $this->layout='ajax';
		if($this->request->is('post')){
			$user= $this->User->findById($id);
			if($user['User']['verify']==$this->request->data['User']['verify']){

				$this->Session->setFlash(__('The verify code is correct'));
				$this->User->id = $id;
				$this->User->saveField('prevIP',$IP);
				return $this->redirect(array('controller'=>'users','action'=>'login'));
				
			}else{
				$this->Session->setFlash(__('The verify code is incorrect'));
			}
		}
	}

	public function role(){
		// $this->layout='ajax';
		if($this->request->is('post')){
			if($this->request->data['User']['role']=="student")
				return $this->redirect(array('controller'=>'students','action'=>'register','student'));
			else
				return $this->redirect(array('controller'=>'teachers','action'=>'register','teacher'));	
		}
	}
	
	public function logout(){	
		$this->Session->setFlash('Good-Bye');
		return $this->redirect($this->Auth->logout());
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
		
		

	}


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
		pr($lectures);
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
