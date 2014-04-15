<?php
class MessagesController extends AppController{

	public function beforeFilter(){
		parent::beforeFilter();

		if($this->Auth->isAuthorized()==false){
			$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
		}
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		return true;

	}
	public function index() {
		$this->set('menu_type','teacher_menu');
		}
	public function viewall(){
		$this->set('menu_type','teacher_menu');
		$user_id = $this->Auth->user('id');
		$this->loadModel('Message');
		 $data = $this->Message->find('all', array(
        'conditions' => array('Message.user_id' => $user_id),
		'order' => array('Message.created' => 'DESC')));
		$this->set('message_data',$data);
		}
	public function sendmessage($teacher_id = null, $lec_id =null) {
		if($this->Auth->user('role')=='student') {
            $this->set('menu_type','student_menu');}
        elseif($this->Auth->user('role')=='teacher'){
            $this->set('menu_type','teacher_menu');		
		} else { 
			$this->set('menu_type','manager_menu');
				}
		$this->set('teacher_id',$teacher_id);
		$this->set('lecture_id',$lec_id);	
		}
	public function detail($mess_id = null,$lec_id = null){
		if($this->Auth->user('role')=='student') {
            $this->set('menu_type','student_menu');}
        elseif($this->Auth->user('role')=='teacher'){
            $this->set('menu_type','teacher_menu');		
		} else { 
			$this->set('menu_type','manager_menu');
				}
		$user_id = $this->Auth->user('id');
		$this->loadModel('Message');
		$mess_data = $this->Message->find('all',array('conditions' => array('Message.id' => $mess_id)));
		$this->set('mess_data',$mess_data);
		$this->loadModel('Lecture');
		$lec_data = $this->Lecture->find('all',array('conditions' => array('Lecture.id' => $lec_id)));
		$this->set('lec_data',$lec_data);
		//for view message
		}
	public function delete($mess_id = null) {
		if($this->Auth->user('role')=='student') {
            $this->set('menu_type','student_menu');}
        elseif($this->Auth->user('role')=='teacher'){
            $this->set('menu_type','teacher_menu');		
		} else { 
			$this->set('menu_type','manager_menu');
				}
		$this->loadModel('Message');
		$this->Message->delete(array('id'=>$mess_id));
		$this->redirect(array('action' => 'viewall'));
		//for dellete message
		}
	public function sending() {
		if($this->Auth->user('role')=='student') {
            $this->set('menu_type','student_menu');}
        elseif($this->Auth->user('role')=='teacher'){
            $this->set('menu_type','teacher_menu');		
		} else { 
			$this->set('menu_type','manager_menu');
				}
		//add to database
    	$teacher_id = $this->request->data['Message']['teacher_id'];
		$lecture_id = $this->request->data['Message']['lecture_id'];
		$message = $this->request->data['Message']['message'];
		if($message == '') {
			$message = 'あなたの講義はCopyrightの問題に侵害するのでレポートさせました. この講義を編集することが必要です！';
			//$message = 'Your lecture was reported. Please check it now if you dont want system delete this lecture';
			}
		$data = array(
						'Message' =>array(	
								'user_id' => $teacher_id,
								'lecture_id' => $lecture_id,
								'content'=> $message
							)
						);
					$this->loadModel('Message');
				
			
					$this->Message->create();
					if($this->Message->save($data)) { $this->set('sent',1);}
					else {$this->set('sent',0);}
			
		//debug($teacher_id);
		//debug($message); die;
		//redirect
		$this->Session->setFlash(_('メッセージを送りました'));
		$this->redirect(array('controller'=>'reports','action' => 'viewreports'));
		}
}
?>