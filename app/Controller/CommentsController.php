<?php
class CommentsController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		// $this->Auth->allow('add');
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='teacher' || $user['role']=='student')
			return true;
		return false;
	}

	public function add(){
		//var_dump($this->request);die;
		if ($this->request->is('post')) {
			$this->request->data['Comment']['user_id'] = $this->Auth->user('id');
			$this->Comment->create();

			// attempt to save
			if ($this->Comment->save($this->request->data)) {
				//success
				echo "da llu";die;
			} else{
				echo "luu loi";die;
			}

		}
	}
}

?>