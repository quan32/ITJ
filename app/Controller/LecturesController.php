<?php
class LecturesController extends AppController{
	var $components = array('Common');
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index', 'add', 'edit', 'delete','preview');
	}

	public function index(){
		$user_id = $this->Auth->user('id');
		$this->loadModel('User');
		$data = $this->User->read(null,$user_id);
		$lectures = $data['Lecture'];
		$this->set("lectures",$lectures);
	}

	public function add(){
		if ($this->request->is('post')) {
			$this->request->data['Lecture']['user_id']=$this->Auth->user('id');
			$this->Lecture->create();

			// attempt to save
			if ($this->Lecture->save($this->request->data)) {
				$lecture = $this->Lecture->find('first', array('order'=>array('Lecture.id'=>'desc')));
				$id=$lecture['Lecture']['id'];
				$this->redirect(array('controller'=>'sources','action' => 'add',$id));
			} 
		}
	}

	public function edit($id){
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

		$this->Lecture->id = $id;
		$this->loadModel('Source');
		$this->Source->deleteAll(array('lecture_id'=>$id));
		

		if(!$this->Lecture->exists())
			throw new NotFoundException(__('Invalid lecture'));

		if($this->Lecture->delete()){
			$this->Session->setFlash(__('Lecture deleted'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Lecture was not deleted'));
			return $this->redirect(array('action' => 'index'));
	}

	public function preview($filename =null){
		$data = $this->Common->view_pdf($filename); // dữ liệu sau khi chuyển đổi không dấu
        $this->set("data",$data); // gán dữ liệu để hiển thị bên view 

	}

}

?>