<?php
class PostsController extends AppController{
	public $helpers = array('Html', 'Form', 'Session', 'Js');
	public $components = array('Session');


	public function index(){
		$this->set('text',"Welcome");
	}

	public function view($id = null){
		if(!$id)
			throw new NotFoundException(__('Invalid post'));

		$post = $this->Post->findById($id);
		if(!$post)
			throw new NotFoundException(__('Invalid post'));
		$this->set('post',$post);
	}

	// public function add(){
	// 	$thread_id = $this->Session->read('thread_id');
	// 	if($this->request->is('post')){
	// 		$user_id = $this->Auth->user('id');
	// 		$this->loadModel('User');
	// 		$user = $this->User->findById($user_id);
	// 		$username = $user['User']['username'];

	// 		$this->request->data['Post']['user_id'] = $user_id;
	// 		$this->request->data['Post']['username'] = $username;
	// 		$this->request->data['Post']['thread_id'] = $thread_id;

	// 		$this->Post->create();
	// 		if($this->Post->save($this->request->data)){
	// 			$this->Session->setFlash(__('Your post has been saved.'));
	// 			return $this->redirect(array('action' => 'index'));
	// 		}
	// 		$this->Session->setFlash(__('Unable to add your post'));
	// 	}
	// }

	public function edit($id = null){
		if($id == null)
			throw new NotFoundException(__('Invalid post'));

		$post = $this->Post->findById($id);
		$thread_id = $post['Post']['thread_id'];

		if($post['Post']['state'] == 0){
			$this->Session->setFlash(__('Your can not edit this message'));
			return $this->redirect(array('controller'=>'threads','action' => 'listPost', $thread_id));
		}
			
		else{
			if(!$post)
				throw new NotFoundException(__('Invalid post'));

			if($this->request->is(array('post', 'put'))){
				
				if($this->Post->save($this->request->data)){
					$this->Session->setFlash(__('Your post has been updated'));
					return $this->redirect(array('controller'=>'threads','action' => 'listPost', $thread_id));
				}
					
			}
			
			if(!$this->request->data){
				$this->request->data=$post;
			}
		}
			
	}

	public function delete($id = null){
		if($id == null)
			throw new NotFoundException(__('Invalid post'));

		if($this->request->is('get'))
			throw new MethodNotAllowedException();

		$post = $this->Post->findById($id);
		$thread_id=$post['Post']['thread_id'];
		if($post['Post']['state'] == 0)
			$this->Session->setFlash(__('You can not delete this message.'));
		else{
			$post['Post']['body']='This message has been deleted';
			$post['Post']['state']=0;

			if($this->Post->save($post)){
				$this->Session->setFlash(__('The post has been deleted.'));
		}
		}
		return $this->redirect(array('controller'=>'threads','action' => 'listPost', $thread_id));
			
	}

	public function isAuthorized($user){
		//All registered users can add posts

		if($this->action === 'index' || $this->action === 'add' || 
			$this->action === 'view'){
			return true;
		}

		//The owner of a post can edit and delete it
		if(in_array($this->action, array('edit', 'delete'))){
			$postId = $this->request->params['pass'][0];
			if($this->Post->isOwnedBy($postId, $user['id']))
				return true;
			
		}

		$this->Session->setFlash(__('You have not privileges'));
		return false;

	}




}

?>