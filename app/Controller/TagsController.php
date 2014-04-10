<?php
class TagsController extends AppController{

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

	public function view($id){
		if($this->Auth->user('role')=='student')
			$this->set('menu_type','student_menu');
		elseif($this->Auth->user('role')=='teacher')
			$this->set('menu_type','teacher_menu');
		else
			$this->set('menu_type','manager_menu');

		$this->loadModel('Vovan');
		$this->loadModel('Lecture');

		$vovans = $this->Vovan->findAllByTagId($id);
		$i=0;
		foreach ($vovans as $vovan) {
			$lecture_id = $vovan['Vovan']['lecture_id'];
			$lecture = $this->Lecture->findById($lecture_id);
			//debug($lecture);
			$lectures[$i++]=$lecture;
		}
		//debug($lectures);die;
		$this->set('lectures',$lectures);

	}
}
?>