<?php
App::uses('File', 'Utility');
define ('UPLOAD_FOLDER', realpath(dirname(__FILE__).DS.'..'.DS.'webroot'.DS.'files'));
class ResultsController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('view');
	}

	public function view($id = null){
		$this->Result->id = $id;
		if(!$this->Result->exists())
			throw new NotFoundException(__('Invalid result'));
		$result = $this->Result->read(null, $id);
		$this->set('file', UPLOAD_FOLDER.DS.'[result]['.$id.'].html');

	}
}

?>