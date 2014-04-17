<?php
class BlocksController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		
		if($this->Auth->isAuthorized()==false){
			$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
		}
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
	public function unblock()
	{
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

public function blockStudent(){
	$this->loadModel('Block');
		if ($this->request->is('post')) {
			$this->request->data['Block']['teacher_id'] = $this->Auth->user('id');
			$this->request->data['Block']['student_id'] = $this->request->data['Block']['studentID'];
			$this->Block->create();

			// attempt to save
			if ($this->Block->save($this->request->data)) {
				$this->redirect(array('controller'=>'teachers','action'=>$this->request->data['Block']['backLink']));
			} else{
				$this->Session->setFlash(_('システムエラー。'));
				$this->redirect(array('action' => $this->request->data['Block']['backLink']));
			}

		}
	}

public function unblockStudent(){
	$this->loadModel('Block');
		if ($this->request->is('post')) {
			$teacher_id = $this->Auth->user('id');
			$student_id = $this->request->data['Block']['studentID'];
			if($this->Block->deleteAll(array('teacher_id'=>$teacher_id,'student_id'=>$student_id))){
				$this->redirect(array('controller'=>'teachers','action'=>$this->request->data['Block']['backLink']));
			} else{
				$this->Session->setFlash(_('システムエラー。'));
				$this->redirect(array('action' => $this->request->data['Block']['backLink']));
			}

		}
	}
}

?>