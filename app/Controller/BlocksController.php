<?php
class BlocksController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('add');
	}

	public function add(){
		//var_dump($this->request);die;
		if ($this->request->is('post')) {
			$this->request->data['Block']['lecture_id'] = $this->Auth->user('id');
			$this->Favorite->create();

			// attempt to save
			if ($this->Favorite->save($this->request->data)) {
				//success
				echo "da llu";die;
			} else{
				echo "luu loi";die;
			}

		}
	}
}

?>