<?php
class ManagersController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('info1', 'info2');
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='manager')
			return true;
		return false;
	}



	public function index(){

	}

	public function info1(){
		
	}
	public function info2(){
		
	}
}
?>