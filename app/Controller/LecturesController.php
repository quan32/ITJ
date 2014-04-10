<?php
class LecturesController extends AppController{
	var $components = array('Common');
	public function beforeFilter(){
		parent::beforeFilter();

		if($this->Auth->isAuthorized()==false){
			$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
		}
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if( ($user['role']=='manager') || ($user['role']=='teacher'))
			return true;
		elseif($user['role']=='student' && in_array($this->action, array('detail','view')))
			return true;
		return false;
	}

	public function index(){
		$this->set('menu_type','teacher_menu');

		$user_id = $this->Auth->user('id');
		$lectures = $this->Lecture->findAllByUserId($user_id);
		$this->set("lectures",$lectures);
	}

	public function add(){
		$this->set('menu_type','teacher_menu');
		if ($this->request->is('post')) {
			if($this->request->data['Lecture']['NQ']==1){

				$exist = $this->Lecture->findByName($this->request->data['Lecture']['name']);
				if($exist){
					$this->Session->setFlash(__('この講義のタイトルは使用されているから、他のタイトルを選んでください。'));
				}else{

					$this->request->data['Lecture']['user_id']=$this->Auth->user('id');
					$this->Lecture->create();
					$tags = $this->request->data['Lecture']['tag'];
					$this->loadModel('Tag');
					$this->loadModel('Vovan');
					
					// attempt to save
					if ($this->Lecture->save($this->request->data)) {
						$lecture = $this->Lecture->find('first', array('order'=>array('Lecture.id'=>'desc')));
						$id=$lecture['Lecture']['id'];
						
						// Su ly tag
						$tags = explode(",", $tags);
						//var_dump($tags);die;
						for($i=0; $i<count($tags); $i++) {
							$tag = $tags[$i];
							$tag = trim($tag);
							// echo $tag;

							$result = $this->Tag->findByContent($tag);
							if($result){
								$tag_id = $result['Tag']['id'];
								$vovan['Vovan']['lecture_id']=$id;
								$vovan['Vovan']['tag_id']=$tag_id;
								$this->Vovan->create();
								if(!$this->Vovan->save($vovan)){
									$this->Session->setFlash(__('Vovanテーブルにデータを保存することは失敗！'));
								}
							}else{
								$new_tag['Tag']['content']=$tag;
								$this->Tag->create();
								if(!$this->Tag->save($new_tag)){
									$this->Session->setFlash(__('Tagテーブルにデータを保存することは失敗！'));
								}
								$i--;
							}

						}

						$this->redirect(array('controller'=>'sources','action' => 'add1',$id));
					} 
				}
				
			}else{
				$this->Session->setFlash(__('この資料の著作権はまだ証明されていない'));
			}
			
		}
	}

	public function edit($id){
		$this->set('menu_type','teacher_menu');
		$this->Lecture->id =$id;
		if(!$this->Lecture->exists()){
			throw new NotFoundException(__('不当な講義'));
		}

		if ($this->request->is('post') || $this->request->is('put')) { 
			if ($this->Lecture->save($this->request->data)) {
				$this->loadModel('Tag');
				$this->loadModel('Vovan');

				//Edit tag
					//Xoa het cac tag cua lecture
				if(!$this->Vovan->deleteAll(array('lecture_id'=>$id))){
					$this->Session->setFlash(__('Vovaテーブルからデータを削除することは失敗！'));

				}else{
					//Them moi lai tat ca cac tag
					$tags = $this->request->data['Lecture']['tag'];
					$tags = explode(",", $tags);
					for($i=0; $i<count($tags); $i++) {
						$tag = $tags[$i];
						$tag = trim($tag);
						// echo $tag;

						$result = $this->Tag->findByContent($tag);
						if($result){
							$tag_id = $result['Tag']['id'];
							$vovan['Vovan']['lecture_id']=$id;
							$vovan['Vovan']['tag_id']=$tag_id;
							$this->Vovan->create();
							if(!$this->Vovan->save($vovan)){
								$this->Session->setFlash(__('Vovanテーブルにデータを保存することは失敗！'));
							}
						}else{
							$new_tag['Tag']['content']=$tag;
							$this->Tag->create();
							if(!$this->Tag->save($new_tag)){
								$this->Session->setFlash(__('Tagテーブルにデータを保存することは失敗！'));
							}
							$i--;
						}

					}

				}	

	            $this->Session->setFlash(__('講義はシステムに保存していた'));
				$this->redirect(array('controller'=>'sources','action' => 'edit',$id));
				}
		        $this->Session->setFlash(
		            __('講義はシステムに保存していない。もう一度してみてください'));
		} else {
			$this->request->data = $this->Lecture->read(null, $id);
		    unset($this->request->data['Lecture']['password']);
		    }
	}

	public function delete($id =null){
		if ($this->request->is(array('post','get'))){
			$this->Lecture->id = $id;
			$this->loadModel('Source');
			$this->loadModel('Vovan');

			//Delete sources in hard disk
			$sources = $this->Source->findAllByLectureId($id);
			foreach($sources as $source){
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
			}
			//Delete sources in database
			$this->Source->deleteAll(array('lecture_id'=>$id));
			//Delete tag of lectures
			$this->Vovan->deleteAll(array('lecture_id'=>$id));
			

			if(!$this->Lecture->exists())
				throw new NotFoundException(__('Invalid lecture'));

			if($this->Lecture->delete()){
				$this->Session->setFlash(__('講義は削除した'));
				return $this->redirect(array('controller'=>'lectures','action'=>'index'));
				// if($this->Auth->user('role')=='teacher')
				// 	return $this->redirect(array('controller'=>'teachers','action'=>'index'));
				// else if($this->Auth->user('role')=='manager')
				// 	return $this->redirect(array('controller'=>'manages','action'=>'lecture'));

			}
			$this->Session->setFlash(__('講義の削除するのは失敗した'));
				return $this->redirect(array('action' => 'index'));
		}else{
			$this->Session->setFlash(__('間違った操作'));
				return $this->redirect(array('controller'=>'teachers','action' => 'index'));
		}
		
	}

	public function preview($id =null){
		$this->set('menu_type','teacher_menu');


		$lecture = $this->Lecture->read(null, $id);
		$sources = $lecture['Source'];
		foreach ($sources as $source) {
			if(in_array($source['type'], array('application/pdf'))){
				$src=$this->Common->view_pdf($source['filename']);
				$this->set('src',$src);
			}
		}

		$this->set('sources', $sources);
		

	}

	public function view($id = null){// TODO hien thi bai giang, file , 
		if($this->Auth->user('role')=='student')
			$this->set('menu_type','student_menu');
		elseif($this->Auth->user('role')=='teacher')
			$this->set('menu_type','teacher_menu');
		else
			$this->set('menu_type','manager_menu');


		$lecture = $this->Lecture->read(null, $id);
		if($this->Auth->user('role')=='student'){
			$count=0;
			foreach ($lecture['Register'] as $register) {
				if($register['user_id']==$this->Auth->user('id'))
					$count++;
			}
			if($count==0){
				$this->Session->setFlash(__('貴方はこの講義を登録していない!'));
				return $this->redirect(array('controller'=>'students','action' => 'lectures_statistics'));
			}
		}
		
		$sources = $lecture['Source'];
		foreach ($sources as $source) {
			if(in_array($source['type'], array('application/pdf'))){
				$src=$this->Common->view_pdf($source['filename']);
				$this->set('src',$src);
			}
		}
		$this->set('sources', $sources);

		//Hien thi comment
		$this->set('lecture', $lecture);
		$this->set('comments', $this->Lecture->Comment->findAllByLectureId($id));
		$this->set('num_liked',count($lecture['Favorite']));
		$isLiked = count($this->Lecture->Favorite->findAllByLectureIdAndUserId($id,$this->Auth->user('id')))!=0 ? 1: 0;
		$this->set('isLiked', $isLiked);
		$this->set('current_user_id', $this->Auth->user('id'));

		//Hien thi tag
		$this->loadModel('Vovan');
		$this->loadModel('Tag');
		$i=0;
		$tags = $this->Vovan->findAllByLectureId($id);
		if($tags){
			foreach ($tags as $tag) {
			$t[$i] = $this->Tag->findById($tag['Vovan']['tag_id']);
			$i++;
			}
			$this->set('tags',$t);
		
		}
		
		
	}

//------xuan----2014/4/9 
	//hien thi chi tiet bai giang

	public function detail($id = null,$currentLocation = null)
	{
		$this->set('menu_type','student_menu');
		if($id == null) 
		{
			if($currentLocation != null)
				{
				$this->Session->setFlash(__('すみません,見つけられない!'));
				return $this->redirect(array('controller'=>'students','action' => $currentLocation));
				}
			else
				{
				$this->Session->setFlash(__('すみません,見つけられない!'));
				return $this->redirect(array('controller'=>'students','action' => 'index'));
				}

		}
		else
		{
		$this->loadModel('Lecture');
	

		$options['joins'] = array(
					    array('table' => 'users',
					        'alias' => 'User',
					        'type' => 'inner',
					        'conditions' => array('Lecture.user_id = User.id' )));
			

		$options['conditions'] = array('Lecture.id' => $id);
		$options['fields'] =array('Lecture.id','Lecture.name','User.fullname','User.id','User.username','User.mobile_No','User.mail','Lecture.cost','Lecture.description');
		$this->Lecture->recursive = -1;

		$data = $this->Lecture->find('all',$options);
		$user_id = $this->Auth->user('id');
		if($data != null)
		{
		// kiem tra bi block ko
		$this->loadModel('Block');
		$isBlock = $this->Block->find('all', array(
			'conditions' => array(
				'student_id' => $user_id,
				'teacher_id' => $data[0]['User']['id']
				)

			));
		if($isBlock != null) 
			$data[0]['Block'] = 1;
		else 
			$data[0]['Block'] = 0;
		}


		$this->set('lecture',$data);
		$this->set('currentLocation',$currentLocation);
// list cac bai da dang ki cua user nay
		$user_id = $this->Auth->user('id');
		$this->loadModel('Register');
			$data_register = $this->Register->find('all',
				array(
					'conditions' => array('Register.user_id' => $user_id,
					'Register.status <>' => 3,
					"Register.created >=" => date('Y-m-d H:i:s', strtotime("-1 weeks"))
						),
					'limit' => 100000000000,
					'fields' => array( 'lecture_id','status','user_id')
					)

				);
			$this->set('list_lectures', $data_register);

		}
	}
	//___________--

}

?>