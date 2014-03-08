<?php
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
		$data = $this->User->read(null,$user_id);
		$lectures = $data['Lecture'];
		$this->set("lectures",$lectures);
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

}
?>