<?php
class ReportsController extends AppController{

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
	public function index($lec_id = null,$lec_title = null,$teacher_name = null) {
		$this->set('menu_type','teacher_menu');
		$this->set('lec_id',$lec_id);
		$this->set('lec_name',$lec_title);
		$this->set('author',$teacher_name);
		if($this->checkReported($lec_id) == 0) { $this->set('reported',0);
		} else {$this->set('reported',1);}
	}
	public function report($lec_id = null) {
		$this->set('menu_type','teacher_menu');
		$this->set('lec_id',$lec_id);
		if($this->checkReported($lec_id) == 0)
		{
			$user_id = $this->Auth->user('id');
			$data = array(
						'Report' =>array(	
								'user_id' => $user_id,
								'lecture_id' => $lec_id,
								'status'=> 1
							)
						);
					$this->loadModel('Report');
				
			
					$this->Report->create();
					if($this->Report->save($data)) { $this->set('reported',1);}
					else {$this->set('reported',0);}
		} else {
			$this->set('reported',2);
			}
	}
	public function viewreports() {
		$this->set('menu_type','manager_menu');
		$this->loadModel('Report');
		$this->Report->recursive = -1;

		//$this->paginate = $options;
		$this->paginate= array(
                'limit' => 5,
                'order' => array('Report.created ' => 'DESC'),
            );
		$data = $this->paginate('Report');

		
	$this->set('reportsdata',$data);
		}
	public function detail($rep_id = null, $lec_id = null, $user_id = null, $rep_status = null) {
		$this->set('menu_type','manager_menu');
		$this->loadModel('User');
		$this->loadModel('Lecture');
		//$this->loadModel('Report');
		//$report = $this->Report->findById($rep_id);
		$user= $this->User->findById($user_id);
		$lecture = $this->Lecture->findById($lec_id);
		$this->set('reporter',$user['User']['fullname']);
		$this->set('lecture',$lecture['Lecture']);
		$this->set('lecture_author',$lecture['User']['fullname']);
		//$this->set('rep_time',$rep_time);
		$this->set('rep_id',$rep_id);
		$this->set('rep_status',$rep_status);
		//debug($report); die;
		//debug($user); die;
		//debug($lecture); die;
		
	

	}
	public function reported($rep_id = null,$lec_id = null) {
		$this->set('menu_type','manager_menu');
		$this->loadModel('Report');
		$this->Report->id = $rep_id;
		$this->Report->saveField('status',2);
		$this->loadModel('Lecture');
		$this->Lecture->id = $lec_id;
		$this->Lecture->saveField('reported',1);
		$this->Session->setFlash(_('賛成！データベースに処理しました'));
		$this->redirect(array('action' => 'viewreports'));
		}
	public function delreport($rep_id = null, $lec_id = null) {
		$this->set('menu_type','manager_menu');
		$this->loadModel('Report');
		$this->Report->delete(array('id'=>$rep_id));
		$this->loadModel('Lecture');
		$this->Lecture->id = $lec_id;
		$this->Lecture->saveField('reported',0);
		$this->Session->setFlash(_('反対！　データベースに処理しました'));
		$this->redirect(array('action' => 'viewreports'));
		}
	public function checkReported($lec_id = null){
		//return 1 neu da report 1 lan roi
		// return 0 neu chua report
		if($lec_id == null ) 
		{
				$this->Session->setFlash(_('システムエラー.見つけない'));
				$this->redirect(array('action' => 'index'));
		}
		$user_id = $this->Auth->user('id');
		$options = array(
			'conditions' => array('Report.lecture_id' => $lec_id,
									'Report.user_id' => $user_id
				)
	 	);

		 $this->loadModel('Report');
		 $this->Report->recursive = -1;
		 $data = $this->Report->find('all', $options);
		 if($data == null) return 0;
	
		 else
		 {
			return 1;
		 }
			}
}