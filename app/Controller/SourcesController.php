<?php
class SourcesController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('add','edit','delete');
	}


	public function add($id =null) {
		if ($this->request->is('post')) {
			// var_dump($this->request->data);die;
			$this->request->data['Source']['lecture_id']=$id;
			$this->request->data['Source']['type']=$this->request->data['Source']['filename']['type'];
			$data = $this->request->data;
			// var_dump($data);

			// if($data['Source']['type']=='application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
			// 	$data['Source']['type']=='application/vnd.oasis.opendocument.text'){
				
			// 	$file=$data['Source']['filename']['tmp_name'];
			// 	// var_dump($file);die;
		 //        // $FilePath='/var/www/ITJ/app/webroot/uploads/'.$file;
		 //        $FilePath = $file;
		 //        $DirPath ='/var/www/ITJ/app/webroot/uploads'; 
			//     $command = 'unoconv --format %s --output %s %s';
		 //        $command = sprintf($command,"pdf", $DirPath, $FilePath);
		 //        system($command, $output);
			// }


			$this->Source->create();


			// attempt to save
			if ($this->Source->save($this->request->data)) {

				$this->Session->setFlash('Your source has been submitted');
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
		$sources = $this->Source->find('all', array('conditions'=>array('lecture_id'=>$id)));
		$this->set('sources', $sources);

		if ($this->request->is('post')) {
			$this->request->data['Source']['lecture_id']=$id;
			$this->request->data['Source']['type']=$this->request->data['Source']['filename']['type'];
			// var_dump($this->request->data);die;

			$this->Source->create();

			// attempt to save
			if ($this->Source->save($this->request->data)) {
				$this->Session->setFlash('Your source has been upload');
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
		$source = $this->Source->findById($id);
		$lecture_id = $source['Source']['lecture_id'];

		$this->Source->id = $id;
		if(!$this->Source->exists())
			throw new NotFoundException(__('Invalid Source'));

		if($this->Source->delete()){
			$this->Session->setFlash(__('Source deleted'));
			return $this->redirect(array('action'=>'edit', $lecture_id));
		}
		$this->Session->setFlash(__('Source was not deleted'));
			return $this->redirect(array('action' => 'edit', $lecture_id));
	}



}

?>