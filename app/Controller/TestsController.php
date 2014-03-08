<?php
define ('UPLOAD_FOLDER', realpath(dirname(__FILE__).DS.'..'.DS.'webroot'.DS.'files'));
class TestsController extends AppController {
	public function beforeFilter(){
		parent::beforeFilter();
		// $this->Auth->allow('index','add','edit','view','view_result', 'delete');
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='student')
			return true;
		return false;
	}

	public function index(){
		$this->Test->recursive = 0;
		$this->set('tests', $this->paginate());
	}

	public function view($id = null){
		$this->Test->id = $id;
		if(!$this->Test->exists())
			throw new NotFoundException(__('Invalid test'));
		
		$this->set('test_id',$id);
		$this->set('test', $this->Test->read(null, $id));
	}

	public function view_result(){
		$test_id = $this->data['Questions']['test_id'];
		$this->Test->id = $test_id;
		$this->set('test', $this->Test->read(null, $test_id));
		$this->set('result', $this->data['Questions']);
	}

	public function add($lecture_id = null){
		if($this->request->is('post')){
			//TODO check if not select file
			//upload file
			$filename = UPLOAD_FOLDER.DS.$this->data['Test']['lecture_id']."Test.tsv";
      		if (move_uploaded_file($this->data['Test']['tsv_file']['tmp_name'],$filename)) {	        
		        //create test
				$this->Test->create();
				if($this->Test->save($this->request->data)){
					//create file
					$this->Test->File->create();
					$test_file_name = $this->data['Test']['lecture_id']."Test.tsv";
					if($this->Test->File->save(array('name' => $test_file_name, 'type' => "TSV", 'test_id' => $this->Test->id))){					
						$this->Session->setFlash(__('The test has been saved'));
						return $this->redirect(array('action'=>'index'));
					} else{
						$this->Session->setFlash('There was a problem saving file. Please try again.');
					}
				} else{
					$this->Session->setFlash('There was a problem saving test. Please try again.');
				}
          	} else {
	            $this->Session->setFlash('There was a problem uploading file. Please try again.');
          	}

			$this->Session->setFlash(__('The test could no be saved. Please try again'));
		}
	}

	public function edit($id = null){
		$this->Test->id =$id;
		if(!$this->Test->exists()){
			throw new NotFoundException(__('Invalid test'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			//TODO check if not select file
			//upload file
			if(!empty($this->data['Test']['tsv_file']['name'])){
				$filename = UPLOAD_FOLDER.DS.$this->data['Test']['lecture_id']."Test.tsv";
	      		if (move_uploaded_file($this->data['Test']['tsv_file']['tmp_name'],$filename)) {

	      		}
			}
      		//update normal data
			if ($this->Test->save($this->request->data)) {
		            $this->Session->setFlash(__('The test has been saved'));
					return $this->redirect(array('action' => 'index')); 
			}
	        $this->Session->setFlash(
	            __('The test could not be saved. Please, try again.'));
		} else {
			$this->request->data = $this->Test->read(null, $id);
	    }

	}


	public function delete($id =null){
		$this->request->onlyAllow('post');

		$this->Test->id = $id;
		if(!$this->Test->exists())
			throw new NotFoundException(__('Invalid test'));

		if($this->Test->delete()){
			//TODO delete file
			//delete link to file
			$this->Test->File->deleteAll(array('File.test_id' => $id), false);
			$this->Session->setFlash(__('Test deleted'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Test was not deleted'));
		return $this->redirect(array('action' => 'index'));

	}


}