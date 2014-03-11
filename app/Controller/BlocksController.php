<?php
class BlocksController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		// $this->Auth->allow('add','delete');
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='teacher')
			return true;
		return false;
	}

	public function add(){
		if ($this->request->is('post')) {
			$this->request->data['Block']['teacher_id'] = $this->Auth->user('id');
			$this->request->data['Block']['student_id'] = $this->request->data['student_id'];
			$this->Block->create();

			// attempt to save
			if ($this->Block->save($this->request->data)) {
				//success
				echo "ブロックした";die;
			} else{
				echo "だブロックしていない";die;
			}

		}
	}
	public function delete(){
		if ($this->request->is('post')){
			$teacher_id = $this->Auth->user('id');
			$student_id = $this->request->data['student_id'];
			if($this->Block->deleteAll(array('teacher_id'=>$teacher_id,'student_id'=>$student_id))){
				//success
				echo "da unblock";die;
			} else{
				echo "unblock loi";die;
			}
		}
		
	}	
}

?>