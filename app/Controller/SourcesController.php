<?php
class SourcesController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
	}
	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='student')
			return false;
		return true;
	}

	public function add1($id =null) {
		$this->set('menu_type','teacher_menu');

		if ($this->request->is('post')) {

			if($this->request->data['Source']['filename']['type']==""){
				$this->Session->setFlash('ファイルを選んでください');
				$this->redirect(array('action' => 'add1', $id));
			}
			
			if($this->request->data['Source']['filename']['type']!='application/pdf'){
				$this->Session->setFlash('ファイルフォーマットが間違ってしまった。PDFだけできる');
				$this->redirect(array('action' => 'add1', $id));
			}

			$this->request->data['Source']['lecture_id']=$id;
			$this->request->data['Source']['type']=$this->request->data['Source']['filename']['type'];
			// debug($this->request->data['Source']['filename']['type']);die;
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

			if($this->request->data['Source']['filename']['type']==""){
				$this->Session->setFlash('ファイルを選んでください');
				$this->redirect(array('action' => 'add', $id));
			}
			// debug($this->request->data['Source']['filename']['type']);die;
			if(!in_array($this->request->data['Source']['filename']['type'], array('image/gif','image/png','image/jpg','image/jpeg','video/mp4','audio/mp3','audio/wav', 'audio/x-wav', 'audio/mpeg', 'audio/x-mpeg-3'))){

				$this->Session->setFlash('ファイルフォーマットが間違ってしまった。ビデオと音声とイメージでけできる');
				$this->redirect(array('action' => 'add', $id));
			}
			

			foreach ($sources as $source) {
				$part1 = str_replace(' - ', '_', $this->request->data['Source']['filename']['name']);
				$part1 = str_replace('-', '_', $part1);
				$part1 = str_replace(' ', '_', $part1);
				if($part1==$source['Source']['filename']){
					$this->Session->setFlash('エラー：このファイルはアップロードされた');
					$this->redirect(array('action' => 'add', $id));
				}	
			}

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

			if($this->request->data['Source']['filename']['type']==""){
				$this->Session->setFlash('ファイルを選んでください');
				$this->redirect(array('action' => 'add', $id));
			}
			// debug($this->request->data['Source']['filename']['type']);die;
			if(!in_array($this->request->data['Source']['filename']['type'], array('image/gif','image/png','image/jpg','image/jpeg','video/mp4','audio/mp3','audio/wav', 'audio/x-wav', 'audio/mpeg', 'audio/x-mpeg-3'))){

				$this->Session->setFlash('ファイルフォーマットが間違ってしまった。ビデオと音声とイメージでけできる');
				$this->redirect(array('action' => 'add', $id));
			}
			

			foreach ($sources as $source) {
				$part1 = str_replace(' - ', '_', $this->request->data['Source']['filename']['name']);
				$part1 = str_replace('-', '_', $part1);
				$part1 = str_replace(' ', '_', $part1);
				if($part1==$source['Source']['filename']){
					$this->Session->setFlash('エラー：このファイルはアップロードされた');
					$this->redirect(array('action' => 'add', $id));
				}	
			}
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

	public function block($id =null){
	    $source = $this->Source->findById($id);
	    $lecture_id = $source['Source']['lecture_id'];

	    $this->Source->id=$id;
	    if($this->Source->saveField('state','blocked')){
	    	return $this->redirect(array('controller'=>'lectures','action'=>'view', $lecture_id));

	    }else{
	    	$this->Session->setFlash(__('ブロックできない'));
	    	return $this->redirect(array('controller'=>'lectures','action'=>'view', $lecture_id));
	    }
	}
	public function unblock($id =null){
	    $source = $this->Source->findById($id);
	    $lecture_id = $source['Source']['lecture_id'];

	    $this->Source->id=$id;
	    if($this->Source->saveField('state','normal')){
	    	return $this->redirect(array('controller'=>'lectures','action'=>'view', $lecture_id));

	    }else{
	    	$this->Session->setFlash(__('ブロックできない'));
	    	return $this->redirect(array('controller'=>'lectures','action'=>'view', $lecture_id));
	    }
	}

	public function managerDelete($id =null){
	    $source = $this->Source->findById($id);
	    $lecture_id = $source['Source']['lecture_id'];

	    //Delete source in hard disk
	    $target=$source['Source']['filename'];
			$target='uploads/'. $target;

			if (file_exists($target)) {
			    unlink($target); // Delete now
				} 
			// See if it exists again to be sure it was removed
			if (file_exists($target)) {
			    echo "Problem deleting " . $target;
				} else {
			    echo "Successfully deleted " . $target;
				}

	    $this->Source->id=$id;
	    if($this->Source->delete()){
	    	return $this->redirect(array('controller'=>'lectures','action'=>'view', $lecture_id));

	    }else{
	    	$this->Session->setFlash(__('削除できない'));
	    	return $this->redirect(array('controller'=>'lectures','action'=>'view', $lecture_id));
	    }
	}


	public function delete($id){

		if ($this->request->is('post')) {
			$source = $this->Source->findById($id);
			$lecture_id = $source['Source']['lecture_id'];

			$this->Source->id = $id;
			if(!$this->Source->exists())
				throw new NotFoundException(__('不当な資料'));

			$target=$source['Source']['filename'];
			$target='uploads/'. $target;
			// debug($target);die;

			if($this->Source->delete()){
				
				if (file_exists($target)) {
				    unlink($target); // Delete now
					} 
				// See if it exists again to be sure it was removed
				if (file_exists($target)) {
				    echo "Problem deleting " . $target;
					} else {
				    echo "Successfully deleted " . $target;
					}

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