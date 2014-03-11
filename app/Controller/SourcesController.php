<?php
class SourcesController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
	}
	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='teacher')
			return true;
		return false;
	}

	public function add1($id =null) {
		$this->set('menu_type','teacher_menu');

		if ($this->request->is('post')) {
			// debug($this->request->data);die;
			$this->request->data['Source']['lecture_id']=$id;
			$this->request->data['Source']['type']=$this->request->data['Source']['filename']['type'];
			$this->Source->create();
			// attempt to save
			if ($this->Source->save($this->request->data)) {

				$this->Session->setFlash('講義の資料は保存されていた');
				$this->redirect(array('action' => 'add', $id));

			// form validation failed
			} else {
				// check if file has been uploaded, if so get the file path
				if (!empty($this->Source->data['Source']['filepath']) && is_string($this->Source->data['Source']['filepath'])) {
					$this->request->data['Source']['filepath'] = $this->Source->data['Source']['filepath'];
				}
			}

		}
	}


	public function add($id =null) {
		$this->set('menu_type','teacher_menu');

		$sources = $this->Source->find('all', array('conditions'=>array('lecture_id'=>$id)));
		$this->set('sources', $sources);

		if ($this->request->is('post')) {
			// debug($this->request->data);die;
			$this->request->data['Source']['lecture_id']=$id;
			$this->request->data['Source']['type']=$this->request->data['Source']['filename']['type'];

			$this->Source->create();
			// attempt to save
			if ($this->Source->save($this->request->data)) {

				$this->Session->setFlash('講義の資料は保存されていた');
				$this->redirect(array('action' => 'add', $id));

			// form validation failed
			} else {
				// check if file has been uploaded, if so get the file path
				if (!empty($this->Source->data['Source']['filepath']) && is_string($this->Source->data['Source']['filepath'])) {
					$this->request->data['Source']['filepath'] = $this->Source->data['Source']['filepath'];
				}
			}

		}
	}

	public function edit($id){
		$this->set('menu_type','teacher_menu');
		$sources = $this->Source->find('all', array('conditions'=>array('lecture_id'=>$id)));
		$this->set('sources', $sources);

		if ($this->request->is('post')) {
			// debug($this->request->data);die;
			$this->request->data['Source']['lecture_id']=$id;
			$this->request->data['Source']['type']=$this->request->data['Source']['filename']['type'];

			$this->Source->create();

			// attempt to save
			if ($this->Source->save($this->request->data)) {
				$this->Session->setFlash('講義の資料はアップロードされていた');
				$this->redirect(array('action' => 'edit', $id));

			// form validation failed
			} else {
				// check if file has been uploaded, if so get the file path
				if (!empty($this->Source->data['Source']['filepath']) && is_string($this->Source->data['Source']['filepath'])) {
					$this->request->data['Source']['filepath'] = $this->Source->data['Source']['filepath'];
				}
			}
		}

	}

	public function delete($id){

		if ($this->request->is('post')) {
			$source = $this->Source->findById($id);
			$lecture_id = $source['Source']['lecture_id'];

			$this->Source->id = $id;
			if(!$this->Source->exists())
				throw new NotFoundException(__('不当な資料'));

			if($this->Source->delete()){
				$this->Session->setFlash(__('削除した'));
				return $this->redirect(array('action'=>'edit', $lecture_id));
			}
			$this->Session->setFlash(__('まだ削除するのが失敗している'));
				return $this->redirect(array('action' => 'edit', $lecture_id));
		}else{
			$this->Session->setFlash(__('エラー操作'));
			return $this->redirect(array('controller'=>'teachers','action' => 'index'));
		}
		
	}

	public function view($filename =null){
		$src = $this->Common->view_pdf($filename); // dữ liệu sau khi chuyển đổi không dấu
        $this->set("src",$src); // gán dữ liệu để hiển thị bên view 
	}

	public function viewMedia($filename = null){
		$this->set('filename', $filename);
	}

}

?>