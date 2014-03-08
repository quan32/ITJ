<?php
App::uses('File', 'Utility');
define ('UPLOAD_FOLDER', realpath(dirname(__FILE__).DS.'..'.DS.'webroot'.DS.'files'));
class TestsController extends AppController {
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index','add','edit','view','view_result', 'delete');
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='student')
			return true;
		return false;
	}

	public function index($lecture_id = null){
		$tests = $this->Test->findAllByLectureId($lecture_id);
		$this->set('tests', $tests);
		$this->set('lecture_id', $lecture_id);
	}

	public function view($id = null){
		$this->Test->id = $id;
		if(!$this->Test->exists())
			throw new NotFoundException(__('Invalid test'));
		
		$this->set('test_id',$id);
		$test = $this->Test->read(null, $id);
		//read tsv
		$file = UPLOAD_FOLDER.DS.$test['TsvFile']['name'];
		$data = $this->Test->read_file($file);
		$this->set('tests',$data['tests']);
		$this->set('test_title', $data['test_title']);
		$this->set('test_sub_title', $data['test_sub_title']);
	}

	public function view_result(){
		//don't use layout
		$this->layout = false;
		$test_id = $this->data['Questions']['test_id'];
		$this->Test->id = $test_id;
		$test = $this->Test->read(null, $test_id);
		//read tsv
		$file = UPLOAD_FOLDER.DS.$test['TsvFile']['name'];
		$data = $this->Test->read_file($file);
		$this->set('tests',$data['tests']);
		$this->set('test_title', $data['test_title']);
		$this->set('test_sub_title', $data['test_sub_title']);

		//read result
		$this->set('result', $this->data['Questions']);
		//luu diem
		$result_id = $this->Test->save_result($data['tests'], $this->data['Questions'], $this->Auth->user('id'));
		//luu file
        $view = new View($this);
        $viewdata = $view->render('view_result',null);
        $file_path = UPLOAD_FOLDER.DS.'[result]['.$result_id.'].html';
        $file = new File($file_path, true);	
        $file->write( $viewdata );
        return $this->redirect(array('controller'=>'results','action'=>'view',$result_id));
	}

	public function add($lecture_id = null){
		if($this->request->is('post')){
			$this->request->data['Test']['lecture_id']=$lecture_id;
			//TODO check if not select file
			//upload file
			$filename = "[Test][".$this->data['Test']['lecture_id']."][".time()."].tsv";
			$file_path = UPLOAD_FOLDER.DS.$filename;
      		if (move_uploaded_file($this->data['Test']['tsv_file']['tmp_name'],$file_path)) {	        
		        //create test
				$this->Test->create();
				if($this->Test->save($this->request->data)){
					//create file
					$this->Test->TsvFile->create();
					if($this->Test->TsvFile->save(array('name' => $filename, 'type' => "TSV", 'test_id' => $this->Test->id))){					
						$this->Session->setFlash(__('The test has been saved'));
						return $this->redirect(array('action'=>'index',$lecture_id));
					} else{
						$this->Session->setFlash('There was a problem saving file. Please try again.');
					}
				} else{
					$this->Session->setFlash('There was a problem saving test. Please try again.');
				}
          	} else {
	            $this->Session->setFlash('There was a problem uploading file. Please try again.');
          	}
          	// $this->set('lecture_id',$lecture_id);
			//$this->Session->setFlash(__('The test could no be saved. Please try again'));
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
			$test = $this->Test->read(null, $id);
			if(!empty($this->data['Test']['tsv_file']['name'])){
				$filename = UPLOAD_FOLDER.DS.$test['TsvFile']['name'];
	      		if (move_uploaded_file($this->data['Test']['tsv_file']['tmp_name'],$filename)) {

	      		}
			}
      		//update normal data
			if ($this->Test->save($this->request->data)) {
		            $this->Session->setFlash(__('The test has been saved'));
					return $this->redirect(array('action'=>'index',$test['Test']['lecture_id'])); 
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
		$test = $this->Test->read(null, $id);
		$filename = UPLOAD_FOLDER.DS.$test['TsvFile']['name'];
		if($this->Test->delete()){
			//delete file
			unlink($filename);
			//delete link to file in db
			$this->Test->TsvFile->deleteAll(array('TsvFile.test_id' => $id), false);
			$this->Session->setFlash(__('Test deleted'));
			return $this->redirect(array('action'=>'index',$test['Test']['lecture_id'])); 
		}
		$this->Session->setFlash(__('Test was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}


}