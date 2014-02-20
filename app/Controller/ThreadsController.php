<?php
class ThreadsController extends AppController{
	public $helpers = array('Html', 'Form', 'Session','Js');
	public $components = array('Session');

	public function index(){
		$user_id = $this->Auth->user('id');
		$this->set('user_id',$user_id);
		$this->set('threads', $this->Thread->find('all'));
	}

	public function listPost($id = null){
		if($id==null)
			throw new NotFoundException(__('Invalid thread'));

		$this->loadModel('Post');
		$posts = $this->Post->findAllByThreadId($id);
		$user_id = $this->Auth->user('id');
		
		$this->set('posts', $posts);
		$this->set('thread_id',$id);
		$this->set('user_id', $user_id);

		if($this->request->is('post')){
			$user_id = $this->Auth->user('id');
			$this->loadModel('User');
			$user = $this->User->findById($user_id);
			$username = $user['User']['username'];

			$this->request->data['Post']['user_id'] = $user_id;
			$this->request->data['Post']['username'] = $username;
			$this->request->data['Post']['thread_id'] = $id;

			$this->Post->create();
			if($this->Post->save($this->request->data)){
				// $this->Session->setFlash(__('Your post has been saved.'));
				return $this->redirect(array('controller'=>'threads', 'action'=>'listPost', $id));
			}
				$this->Session->setFlash(__('Unable to add your post'));
		}
	}

	public function listPost1($id = null){
		if($id==null)
			throw new NotFoundException(__('Invalid thread'));

		$user_id = $this->Auth->user('id');
		$this->layout='ajax';
		$this->loadModel('Post');
		
		$posts = $this->Post->findAllByThreadId($id);	
		$this->set('posts', $posts);
		$this->set('user_id',$user_id);

	}

	public function view($id = null){
		if($id==null)
			throw new NotFoundException(__('Invalid thread'));

		$thread = $this->Thread->findById($id);
		if(!$thread)
			throw new NotFoundException(__('Invalid thread'));
		$this->set('thread',$thread);
	}

	public function add(){
		if($this->request->is('post')){
			$user_id=$this->Auth->user('id');
			$this->loadModel('User');
			$user = $this->User->findById($user_id);
			$username = $user['User']['username'];

			$this->request->data['Thread']['user_id'] = $user_id;
			$this->request->data['Thread']['username'] = $username;

			$this->Thread->create();
			if($this->Thread->save($this->request->data)){
				$this->Session->setFlash(__('Your thread has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to add your thread'));
		}
	}

	public function edit($id = null){
		if(!$id)
			throw new NotFoundException(__('Invalid thread'));

		$thread = $this->Thread->findById($id);
		if(!$thread)
			throw new NotFoundException(__('Invalid thread'));
		if($this->request->is(array('post', 'put'))){
			if($this->request->data){
				$this->request->data['Thread']['user_id']=$thread['Thread']['user_id'];
				$this->request->data['Thread']['username']=$thread['Thread']['username'];
				//var_dump($this->request->data);die;
				if($this->Thread->save($this->request->data)){
					$this->Session->setFlash(__('Your thread has been updated'));
				}else{
					$this->Session->setFlash(__('Your thread can not updated'));
				}
			}
			return $this->redirect(array('action' => 'index'));
		}
			
		if(!$this->request->data){
			$this->request->data= $thread;
		}
	}

	public function delete($id = null){
		if($this->request->is('get'))
			throw new MethodNotAllowedException();
		if($this->Thread->delete($id)){
			$this->Session->setFlash(
				__('The thread has been deleted.'));
			return $this->redirect(array('action' => 'index'));
		}
			
	}

	public function isAuthorized($user){
		//All registered users can add posts

		if($this->action === 'index' || $this->action === 'add' || 
			$this->action === 'view' || $this->action === 'listPost' || $this->action === 'listPost1'){
			return true;
		}

		//The owner of a thread can edit and delete it
		if(in_array($this->action, array('edit', 'delete'))){
			$threadId = $this->request->params['pass'][0];
			if($this->Thread->isOwnedBy($threadId, $user['id']))
				return true;
			
		}

		$this->Session->setFlash(__('You have not privileges'));
		return false;

	}

}

?>