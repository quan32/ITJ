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

	public function index(){

	}

	public function register($role =null){
		 // var_dump($role);

		if($this->request->is('post')){
			// var_dump($this->request->data);die;
			$this->request->data['User']['role']=$role;
			$this->loadModel('User');
			$this->User->create();
			if($this->User->save($this->request->data)){
				$this->Session->setFlash(__('The user has been saved'));
				return $this->redirect(array('controller'=>'users','action'=>'login'));
			}

			$this->Session->setFlash(__('The user could no be saved. Please try again'));
		}
	}
}
?>