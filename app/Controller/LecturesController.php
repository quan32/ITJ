<?php
class LecturesController extends AppController{
	var $components = array('Common');
	public function beforeFilter(){
		parent::beforeFilter();
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if( ($user['role']=='manager') || ($user['role']=='teacher') || (($user['role']=='student') && ($this->action=='view')))
			return true;
		return false;
	}

	public function index(){
		$this->set('menu_type','teacher_menu');

		$user_id = $this->Auth->user('id');
		$lectures = $this->Lecture->findAllByUserId($user_id);
		$this->set("lectures",$lectures);
	}

	public function add(){
		$this->set('menu_type','teacher_menu');
		if ($this->request->is('post')) {
			if($this->request->data['Lecture']['NQ']==1){
				$this->request->data['Lecture']['user_id']=$this->Auth->user('id');
				$this->Lecture->create();

				// attempt to save
				if ($this->Lecture->save($this->request->data)) {
					$lecture = $this->Lecture->find('first', array('order'=>array('Lecture.id'=>'desc')));
					$id=$lecture['Lecture']['id'];
					$this->redirect(array('controller'=>'sources','action' => 'add1',$id));
				} 
			}else{
				$this->Session->setFlash(__('Ban chua dam bao ve tinh hop phap cua tai lieu nay'));
			}
			
		}
	}

	public function edit($id){
		$this->set('menu_type','teacher_menu');
		$this->Lecture->id =$id;
		if(!$this->Lecture->exists()){
			throw new NotFoundException(__('Invalid Lecture'));
		}

		if ($this->request->is('post') || $this->request->is('put')) { 
			if ($this->Lecture->save($this->request->data)) {
		            $this->Session->setFlash(__('The Lecture has been saved'));
					$this->redirect(array('controller'=>'sources','action' => 'edit',$id));
				}
		        $this->Session->setFlash(
		            __('The Lecture could not be saved. Please, try again.'));
		} else {
			$this->request->data = $this->Lecture->read(null, $id);
		    unset($this->request->data['Lecture']['password']);
		    }
	}

	public function delete($id =null){
		if ($this->request->is(array('post','get'))){
			$this->Lecture->id = $id;
			$this->loadModel('Source');
			$this->Source->deleteAll(array('lecture_id'=>$id));
			

			if(!$this->Lecture->exists())
				throw new NotFoundException(__('Invalid lecture'));

			if($this->Lecture->delete()){
				$this->Session->setFlash(__('Lecture deleted'));
				if($this->Auth->user('role')=='teacher')
					return $this->redirect(array('controller'=>'teachers','action'=>'index'));
				else if($this->Auth->user('role')=='manager')
					return $this->redirect(array('controller'=>'manages','action'=>'lecture'));

			}
			$this->Session->setFlash(__('Lecture was not deleted'));
				return $this->redirect(array('action' => 'index'));
		}else{
			$this->Session->setFlash(__('Thao tac loi'));
				return $this->redirect(array('controller'=>'teachers','action' => 'index'));
		}
		
	}

	public function preview($id =null){
		$this->set('menu_type','teacher_menu');
		$lecture = $this->Lecture->read(null, $id);
		$sources = $lecture['Source'];
		foreach ($sources as $source) {
			if(in_array($source['type'], array('application/pdf'))){
				$src=$this->Common->view_pdf($source['filename']);
				$this->set('src',$src);
			}
		}

		$this->set('sources', $sources);
		

	}

	public function view($id = null){// TODO hien thi bai giang, file , 
		if($this->Auth->user('role')=='student')
			$this->set('menu_type','student_menu');
		elseif($this->Auth->user('role')=='teacher')
			$this->set('menu_type','teacher_menu');
		else
			$this->set('menu_type','manager_menu');

		$lecture = $this->Lecture->read(null, $id);
		$sources = $lecture['Source'];
		foreach ($sources as $source) {
			if(in_array($source['type'], array('application/pdf'))){
				$src=$this->Common->view_pdf($source['filename']);
				$this->set('src',$src);
			}
		}
		$this->set('sources', $sources);

		//Hien thi comment
		$this->set('lecture', $lecture);
		$this->set('comments', $this->Lecture->Comment->findAllByLectureId($id));
		$this->set('num_liked',count($lecture['Favorite']));
		$isLiked = count($this->Lecture->Favorite->findAllByLectureIdAndUserId($id,$this->Auth->user('id')))!=0 ? 1: 0;
		$this->set('isLiked', $isLiked);
		$this->set('current_user_id', $this->Auth->user('id'));
	}

}

?>