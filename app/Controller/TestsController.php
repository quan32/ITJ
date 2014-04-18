<?php
App::uses('File', 'Utility');
define ('UPLOAD_FOLDER', realpath(dirname(__FILE__).DS.'..'.DS.'webroot'.DS.'files'));
class TestsController extends AppController {
	public function beforeFilter(){
		parent::beforeFilter();
		if($this->Auth->isAuthorized()==false){
			$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
		}
		$this->set('user_role', $this->Auth->user('role'));
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='teacher' || $user['role']=='manager')
			return true;
		elseif($user['role']=='student' && in_array($this->action, array('index','view','view_result')))
			return true;
		return false;
	}

	public function index($lecture_id = null){
		$this->set('menu_type','teacher_menu');
		$tests = $this->Test->findAllByLectureId($lecture_id);
		$this->set('tests', $tests);
		$this->set('lecture_id', $lecture_id);
	}

	public function view($id = null){
		//check hoc sinh co the view
		if($this->Auth->user('role')=='student')
		{
		$test = $this->Test->findById($id);
		if($test == null)
			$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
		else
		{
			$isBlock = $this->checkBlockByLectureID($test['Test']['lecture_id']);

			if($isBlock == 1) $this->redirect(array('controller'=>'pages','action'=>'display', 'error'));

			if(($this->getStatusLecture($test['Test']['lecture_id'])) == 0) 
				$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			
			//check giao vien nay bi delete , lock ko?
			$this->loadModel('Lecture');
			$this->Lecture->recursive = 1;
			$lecture = $this->Lecture->findById($test['Test']['lecture_id']);
			if($lecture == null) $this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			else
			{
				
				if(($lecture['User']['state'] == 'locked')||($lecture['User']['state'] == 'deleted'))
					$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			}
			$this->Lecture->recursive = 1;
		}
		}
		// ko cho giao vien khac xem
		if($this->Auth->user('role') == 'teacher')
		{
			$test = $this->Test->findById($id);	
			if($test == null) $this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			else
			{
			$this->loadModel('Lecture');
			$this->Lecture->recursive = 1;
			$lecture = $this->Lecture->findById($test['Test']['lecture_id']);
			if($lecture == null) $this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			else
			{
				
				if($lecture['Lecture']['user_id'] != $this->Auth->user('id'))
					$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			}
				
				
			}
		}
		

		//-----end check by xuan--------------
		if($this->Auth->user('role')=='student')
			$this->set('menu_type','student_menu');
		elseif($this->Auth->user('role')=='teacher')
			$this->set('menu_type','teacher_menu');
		elseif($this->Auth->user('role')=='manager')
			$this->set('menu_type','manager_menu');

		$this->Test->id = $id;
		if(!$this->Test->exists())
			throw new NotFoundException(__('不当なテスト'));
		
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
		if($this->Auth->user('role')=='student')
			$this->set('menu_type','student_menu');
		elseif($this->Auth->user('role')=='teacher')
			$this->set('menu_type','teacher_menu');
		elseif($this->Auth->user('role')=='manager')
			$this->set('menu_type','manager_menu');
		
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
		$this->set('menu_type','teacher_menu');
		if($this->request->is('post')){
			// var_dump($this->request->data);die;
			if($this->request->data['Test']['tsv_file']['type']!='text/tab-separated-values'){
				$this->Session->setFlash('ファイルフォーマットが間違ってしまった。TSVだけできる');
				$this->redirect(array('action' => 'add', $lecture_id));
			}

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
						$this->Session->setFlash(__('テストは保存されていた'));
						return $this->redirect(array('action'=>'index',$lecture_id));
					} else{
						$this->Session->setFlash('ファイルの保存するエラーが起きてしまった。してみてください。');
					}
				} else{
					$this->Session->setFlash('テストの保存するエラーが起きてしまった。してみてください。');
				}
          	} else {
	            $this->Session->setFlash('アップロードするエラーが起きてしまった。してみてください。');
          	}
          	// $this->set('lecture_id',$lecture_id);
			//$this->Session->setFlash(__('The test could no be saved. Please try again'));
		}
	}

	public function edit($id = null){
		$this->set('menu_type','teacher_menu');
		$this->Test->id =$id;
		if(!$this->Test->exists()){
			throw new NotFoundException(__('不当なテスト'));
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
		            $this->Session->setFlash(__('テストは保存されていた'));
					return $this->redirect(array('action'=>'index',$test['Test']['lecture_id'])); 
			}
	        $this->Session->setFlash(
	            __('テストは保存られなかった。してみてください。'));
		} else {
			$this->request->data = $this->Test->read(null, $id);
	    }

	}


	public function delete($id =null){
		// $this->request->onlyAllow('post');

		$this->Test->id = $id;
		if(!$this->Test->exists())
			throw new NotFoundException(__('不当なテスト'));
		$test = $this->Test->read(null, $id);
		$filename = UPLOAD_FOLDER.DS.$test['TsvFile']['name'];
		if($this->Test->delete()){
			//delete file
			unlink($filename);
			//delete link to file in db
			$this->Test->TsvFile->deleteAll(array('TsvFile.test_id' => $id), false);
			$this->Session->setFlash(__('テストは削除した'));
			return $this->redirect(array('action'=>'index',$test['Test']['lecture_id'])); 
		}
		$this->Session->setFlash(__('テストはまだ削除していない'));
		return $this->redirect(array('action' => 'index'));
	}

	public function block($id =null){
		$this->Test->id = $id;
		$test = $this->Test->findById($id);

		if(!$this->Test->exists())
			throw new NotFoundException(__('不当なテスト'));
		if($this->Test->saveField('state','blocked')){
			$this->Session->setFlash(__('テストはブロックした'));
			return $this->redirect(array('action'=>'index',$test['Test']['lecture_id'])); 
		}
		$this->Session->setFlash(__('テストはまだブロックしていない'));
		return $this->redirect(array('action'=>'index',$test['Test']['lecture_id']));
	}

	public function unblock($id =null){
		$this->Test->id = $id;
		$test = $this->Test->findById($id);

		if(!$this->Test->exists())
			throw new NotFoundException(__('不当なテスト'));
		if($this->Test->saveField('state','normal')){
			$this->Session->setFlash(__('テストはアンチブロックした'));
			return $this->redirect(array('action'=>'index',$test['Test']['lecture_id'])); 
		}
		$this->Session->setFlash(__('テストはまだブロックしてる'));
		return $this->redirect(array('action'=>'index',$test['Test']['lecture_id']));
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