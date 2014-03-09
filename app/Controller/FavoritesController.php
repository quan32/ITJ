<?php
class FavoritesController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('add','delete');
	}

	public function add(){
		if ($this->request->is('post')) {
			$this->request->data['Favorite']['user_id'] = $this->Auth->user('id');
			$this->request->data['Favorite']['lecture_id'] = $this->request->data['lecture_id'];
			$this->Favorite->create();

			// attempt to save
			if ($this->Favorite->save($this->request->data)) {
				//success
				echo "da like";die;
			} else{
				echo "like loi";die;
			}

		}
	}

	public function delete(){
		if ($this->request->is('post')){
			$user_id = $this->Auth->user('id');
			$lecture_id = $this->request->data['lecture_id'];
			if($this->Favorite->deleteAll(array('lecture_id'=>$lecture_id,'user_id'=>$user_id))){
				//success
				echo "da dislike";die;
			} else{
				echo "dislike loi";die;
			}
		}
		
	}
}

?>