<?php
class UsersController extends AppController{

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('add', 'logout');
	}

	public function index(){
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	public function view($id = null){
		$this->User->id = $id;
		if(!$this->User->exists())
			throw new NotFoundException(__('Invalid user'));

		$this->set('user', $this->User->read(null, $id));
	}

	public function add($id = null){
		if($this->request->is('post')){
			//var_dump($this->request->data);die;
			$this->User->create();
			if($this->User->save($this->request->data)){
				$this->Session->setFlash(__('The user has been saved'));
				return $this->redirect(array('action'=>'login'));
			}

			$this->Session->setFlash(__('The user could no be saved. Please try again'));
		}
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
		$this->request->onlyAllow('post');

		$this->User->id = $id;
		if(!$this->User->exists())
			throw new NotFoundException(__('Invalid user'));

		if($this->User->delete()){
			$this->Session->setFlash(__('User deleted'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		return $this->redirect(array('action' => 'index'));

	}

	public function login(){
		if($this->request->is('post')){
			//var_dump($this->Auth);
			if($this->Auth->login()){
				$this->Session->setFlash('Your are logged in');
				// var_dump($this->Auth->user('role'));die;
				if($this->Auth->user('role')=='admin')
					return $this->redirect(array('action'=>'index'));
				elseif($this->Auth->user('role')=='teacher')
					return $this->redirect(array('controller'=>'threads','action'=>'index'));
				else
					return $this->redirect(array('controller'=>'posts','action'=>'index'));
			}
			else 
				$this->Session->setFlash(__('Invalid username or password, try again'));
		}
	}

	public function signin(){

	}

	
	public function logout(){
		$this->Session->setFlash('Good-Bye');
		return $this->redirect($this->Auth->logout());
	}

}

?>
