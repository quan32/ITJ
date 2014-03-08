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
}
?>