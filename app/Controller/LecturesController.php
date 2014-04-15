<?php
class LecturesController extends AppController{
	var $components = array('Common');
	public function beforeFilter(){
		parent::beforeFilter();

		if($this->Auth->isAuthorized()==false){
			$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
		}
		$this->set('user_role', $this->Auth->user('role'));
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
		$options = array('conditions' => array('user_id' => $user_id),
						'limit' => 5
			);
		$this->paginate = $options;
		$this->Lecture->recursive = -1;
		$lectures = $this->paginate('Lecture');
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
		//Check co the xem dc ko doi voi hoc sinh nay

		if($this->Auth->user('role') == 'student')
		{
			$this->loadModel('Lecture');
			$user_id = $this->Auth->user('id');
			// check bi block boi giao vien nay
			$isBlock = $this->checkBlockByLectureID($id);
			if($isBlock == 1) $this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			//check dang ki trong thoi gian cho phep
			if(($this->getStatusLecture($id)) == 0) 
				$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			//check giao vien nay bi delete , lock ko?
			$this->Lecture->recursive = 1;
			$data = $this->Lecture->findById($id);
			if($data == null) $this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			else
			{
				
				if(($data['User']['state'] == 'locked')||($data['User']['state'] == 'deleted'))
					$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			}


		}
		// ko cho giao vien khac xem
		if($this->Auth->user('role') == 'teacher')
		{
			$this->Lecture->recursive = 1;
			$data = $this->Lecture->findById($id);	
			if($data == null) $this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			else
			{
				if($data['Lecture']['user_id'] != $this->Auth->user('id'))
					$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			}
		}
		
		//------------------------------------
		if($this->Auth->user('role')=='student')
			$this->set('menu_type','student_menu');
		elseif($this->Auth->user('role')=='teacher')
			$this->set('menu_type','teacher_menu');
		else
			$this->set('menu_type','manager_menu');

		$lecture = $this->Lecture->read(null, $id);
		if(!$lecture){
			$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
		}
		
		if($this->Auth->user('role')=='student'){
			$count=0;
			foreach ($lecture['Register'] as $register) {
				if($register['user_id']==$this->Auth->user('id')){
					$count++;
					$this->set('register_item', $register['id']);
				}
			}
			if($count==0){

				$this->Session->setFlash(__('貴方はこの講義を登録していない!'));
				$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
				
			}
		}
		
		$sources = $lecture['Source'];
		foreach ($sources as $source) {
			if(in_array($source['type'], array('application/pdf'))){
				$src=$this->Common->view_pdf($source['filename']);
				$this->set('src',$src);
				$this->set('pdf_id', $source['id']);
				$this->set('pdf_state',$source['state']);
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
		$this->set('role',$this->Auth->user('role'));

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

// //------xuan----2014/4/9 
// 	//hien thi chi tiet bai giang

// 	public function detail($id = null,$currentLocation = null)
// 	{
// 		$this->set('menu_type','student_menu');
// 		if($id == null) 
// 		{
// 			if($currentLocation != null)
// 				{
// 				$this->Session->setFlash(__('すみません,見つけられない!'));
// 				return $this->redirect(array('controller'=>'students','action' => $currentLocation));
// 				}
// 			else
// 				{
// 				$this->Session->setFlash(__('すみません,見つけられない!'));
// 				return $this->redirect(array('controller'=>'students','action' => 'index'));
// 				}

// 		}
// 		else
// 		{
// 		$this->loadModel('Lecture');
	

// 		$options['joins'] = array(
// 					    array('table' => 'users',
// 					        'alias' => 'User',
// 					        'type' => 'inner',
// 					        'conditions' => array('Lecture.user_id = User.id' )));
			

// 		$options['conditions'] = array('Lecture.id' => $id);
// 		$options['fields'] =array('Lecture.id','Lecture.name','User.fullname','User.id','User.username','User.mobile_No','User.mail','Lecture.cost','Lecture.description');
// 		$this->Lecture->recursive = -1;

// 		$data = $this->Lecture->find('all',$options);
// 		$user_id = $this->Auth->user('id');
// 		if($data != null)
// 		{
// 		// kiem tra bi block ko
// 		$this->loadModel('Block');
// 		$isBlock = $this->Block->find('all', array(
// 			'conditions' => array(
// 				'student_id' => $user_id,
// 				'teacher_id' => $data[0]['User']['id']
// 				)

// 			));
// 		if($isBlock != null) 
// 			$data[0]['Block'] = 1;
// 		else 
// 			$data[0]['Block'] = 0;
// 		}


// 		$this->set('lecture',$data);
// 		$this->set('currentLocation',$currentLocation);
// // list cac bai da dang ki cua user nay
// 		$user_id = $this->Auth->user('id');
// 		$this->loadModel('Register');
// 			$data_register = $this->Register->find('all',
// 				array(
// 					'conditions' => array('Register.user_id' => $user_id,
// 					'Register.status <>' => 3,
// 					"Register.created >=" => date('Y-m-d H:i:s', strtotime("-1 weeks"))
// 						),
// 					'limit' => 100000000000,
// 					'fields' => array( 'lecture_id','status','user_id')
// 					)

// 				);
// 			$this->set('list_lectures', $data_register);

// 		}
// 	}
// 	//___________--

/*
*
* 10.04
* Author Xuan
* Thong ke cac thong so cua mot bai giang : so like, so tham khao, hoc sinh nao tham gia...
*/
public function statisticsOfALecture($lecture_id = null,$backLink = null)
{
	$this->set('menu_type','teacher_menu');

	if($lecture_id == null ) 
	{
		$this->Session->setFlash(_('システムエラー, 見つけない'));
		$this->redirect(array('action' => 'index'));
	}
	$this->loadModel('Lecture');
	$this->Lecture->recursive = -1;
	$lecture = $this->Lecture->findById($lecture_id);
	if($lecture == null)
	{
		$this->Session->setFlash(_('システムエラー, 見つけない'));
		$this->redirect(array('action' => 'index'));
	}
	//backLink
	$this->set('backLink',$backLink);
	$this->set('lectureName',$lecture['Lecture']['name']);
//Tinh so like bai giang nay:
	$numLike = $this->countLikeByLecture($lecture_id);
	$this->set('numLike' , $numLike);

// So lan tham khao
	$referenceTimes = $this->countReferenceTimesByLecture($lecture_id);
	$this->set('referenceTimes',$referenceTimes);
// So lan hoc sinh dang ki bai giang nay
	$numRegister = $this->countRegisterByLecture($lecture_id);
	$this->set('numRegister',$numRegister);
// So lan dang ky bai hoc trong thang nay
	$numRegisterThisMonth = $this->countRegisterByLectureAndMonth($lecture_id);
// Thong ke hoc sinh nao da mua bai giang nay (ko phai la da hoc, vi co nhung thang dang ki ma ko hoc)
	$this->loadModel('Register');


	$user_id = $this->Auth->User('id');
	$options['joins'] = array(
					    array('table' => 'lectures',
					        'alias' => 'Lecture',
					        'type' => 'inner',
					        'conditions' => array('Lecture.id = Register.lecture_id' )),

					    array('table' => 'users',
					    	'alias' => 'User',
					    	'type' => 'inner',
					    	'conditions' => array('User.id = Register.user_id')
					    	)
					       );
	$options['conditions'] = array('Register.lecture_id' => $lecture_id	);
	$options['fields'] =array('Lecture.id','Lecture.name','User.id','User.username','User.fullname','User.mail','User.role','User.mobile_No','count(Register.user_id) as registerTimes');
	$options['limit'] = 5;
	$options['group'] = 'Register.user_id';
	$this->loadModel('Register');
	$this->Register->recursive = -1;

	$this->paginate = $options;

	$data = $this->paginate('Register');
	
	$this->set('users',$data);



}
/* -------------
*	caculate number like of the lecture
* 	07.04 
*	Author : xuan
*/
public function countLikeByLecture($lecture_id = null)
{

	if($lecture_id == null) return 0;
	$this->loadModel('Favorite');
	$numLike = $this->Favorite->find('count', array(
    'conditions' => array('Favorite.lecture_id' => $lecture_id)));
    return $numLike;
}

/*
*	caculate number of times which this lecture is registed (not number of student, because student can two time register a lectures)
* 07.04
* Author Xuan
*/

public function countRegisterByLecture($lecture_id = null){

		if($lecture_id == null ) return 0;
		$this->loadModel('Register');
		$numRegister = $this->Register->find('count', array(
			'conditions' => array('Register.lecture_id' => $lecture_id)
			));
		return $numRegister;
	}

/*
*	caculate number of times  this lecture is registed in the month which (not number of student, because student can two time register a lectures)
* 07.04
* Author Xuan
*/
public function countRegisterByLectureAndMonth($lecture_id = null, $month = null){

//debug(date('n')); die;
	if($lecture_id == null ) return 0;
	$this->loadModel('Register');
	$numRegisterInMonth = $this->Register->find('count', array(
		'conditions' => array('Register.lecture_id' => $lecture_id,
		'MONTH(Register.created)' => $month
			)
		));
	return $numRegisterInMonth;

}
	
public function countReferenceTimesByLecture($lecture_id = null){
	if($lecture_id == null ) return 0;
	$this->loadModel('Lecture');
	$numReference = $this->Lecture->find('count',
		array('conditions' => array('Lecture.id' => $lecture_id)));
	return $numReference;
	}

// mot so ham check
public function isBlock($teacher_id = null){
// 0 la ko block
// 1 la block
	if($teacher_id == null ) 
			{
					$this->Session->setFlash(_('システムエラー。見つけられません。'));
					$this->redirect(array('action' => 'index'));
			}

	$student_id = $this->Auth->user('id');
	$this->loadModel('Block');


	$options = array(
						'conditions' => array(
							'Block.student_id' => $student_id,
							'Block.teacher_id' => $teacher_id
							
						),
											

				);
			$this->Block->recursive = -1;
			$data = $this->Block->find('all',$options);
			if($data == null) return 0;
			else return 1;
}

public function checkBlockByLectureID($lecture_id = null)
{
	if($lecture_id == null) {
		$this->redirect(array('action' => 'index'));
	}
	else
	{
		$this->loadModel('Lecture');
		$this->Lecture->recursive = -1;
		$data = $this->Lecture->findById($lecture_id);
		if($data == null)
		{
			return 3;
		}
		else
			return ($this->isBlock($data['Lecture']['user_id']));
	}

}
public function getStatusLecture($lecture_id = null){
/* 
- Chua dang ki return 0
- Da dang ki trong vong mot tuan
		- chua hoc return 1
		- da hoc return 2

*/	
	$constantExpireTime = $this->Constant->findByName('expire_time');
	$expireTime = $constantExpireTime['Constant']['value'];
	$stringExpireTime = "-".$expireTime." days";	
	
		if($lecture_id == null ) 
		{
				$this->Session->setFlash(_('システムエラー。見つけられません。'));
				$this->redirect(array('action' => 'index'));
		}
	$user_id = $this->Auth->user('id');
	$options = array(
	 	'conditions' => array('Register.lecture_id' => $lecture_id,
	 	'Register.user_id' => $user_id,
		'Register.created >=' => date('Y-m-d H:i:s', strtotime($stringExpireTime))
	 		)
	 	);

	 $this->loadModel('Register');
	 $this->Register->recursive = -1;
	 $data = $this->Register->find('all', $options);
	 if($data == null) return 0;

	 else
	 {
	 	if($data[0]['Register']['status'] == 0 )
	 		return 1;
	 	else
	 		return 2;
	 }
	

	}	
}

?>