<?php
App::uses('File', 'Utility');
define ('UPLOAD_FOLDER', realpath(dirname(__FILE__).DS.'..'.DS.'webroot'.DS.'files'));
class ResultsController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
	}
	public function isAuthorized($user){
		return true;
	}
	
	public function index($test_id = null){
		$this->set('menu_type','teacher_menu');
		$results = $this->Result->findAllByTestId($test_id);
		$this->set('results', $results);
		$this->set('test_id', $test_id);
	}

	public function view($id = null){
		if($this->Auth->user('role')=='student')
			$this->set('menu_type','student_menu');
		elseif($this->Auth->user('role')=='teacher')
			$this->set('menu_type','teacher_menu');
		
		$this->Result->id = $id;
		if(!$this->Result->exists())
			throw new NotFoundException(__('Invalid result'));
		$result = $this->Result->read(null, $id);
		$this->set('file', UPLOAD_FOLDER.DS.'[result]['.$id.'].html');

	}
}

?>