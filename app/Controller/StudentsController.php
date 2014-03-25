<?php
class StudentsController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('register');
		
		if($this->Auth->isAuthorized()==false && $this->action!='register'){
			$this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
			}
		}
	

	public function isAuthorized($user){
		// Only student can use these function
		if($user['role']=='student')
			return true;
		return false;

	}


	public function register($role =null){
		$this->set('menu_type','empty');
		 // var_dump($role);

		if($this->request->is('post')){
			$this->loadModel('User');
			if($this->User->findByUsername($this->request->data['User']['username'])){
				$this->Session->setFlash(__('このアカウントはシステムに存在している。他のアカウントを選んでください'));
				unset($this->request->data['User']['password']);
				// return $this->redirect(array('controller'=>'users','action'=>'login'));
			}else{
				$this->request->data['User']['role']=$role;
				$this->request->data['User']['prevIP']=$this->request->clientIp();
				$this->loadModel('User');
				$this->User->create();
				if($this->User->save($this->request->data)){
					$log="INFO, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 学生として成功して登録した';
					$this->Log->writeLog('new_user.txt',$log);
					$this->Session->setFlash(__('アカウントはデータベースに保存した'));
					return $this->redirect(array('controller'=>'users','action'=>'login'));
				}

				$this->Session->setFlash(__('アカウントはデータベースに保存できなかった。もう一度入力してみてください'));
				$log="INFO, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 学生として成功して登録した';
				$this->Log->writeLog('new_user.txt',$log);
			}
			
		}
	}

	public function index(){

		$date = date('Y-m-d H:i:s');
//set menu
		$this->set('menu_type','student_menu');
//lay hang so he thong
		$cost = 20000;
		$this->set('cost',$cost);
	//lay 5 bai giang moi nhat trong he thong ma user nay dang ki trong vong 1 tuan
		$user_id = $this->Auth->user('id');
		$this->loadModel('Register');
		$this->loadModel('User');
		$this->loadModel('Lecture');

		$options = 	array(
					'joins' => array(
								    array('table' => 'registers',
								        'alias' => 'Register',
								        'type' => 'inner',
								        'conditions' => array('Lecture.id = Register.lecture_id')
								    ),
								    array(
								    	'table' => 'users',
								    	'alias' => 'User',
								    	'type'  => 'inner',
								    	'conditions' => array('Lecture.user_id = User.id')
								    	)
			            
									),
					'conditions' => array('Register.user_id' => $user_id,
							 'Register.created >=' => date('Y-m-d H:i:s', strtotime("-1 weeks"))),
											
					
			 		'fields' => array('Lecture.id', 'Lecture.name','Lecture.cost','User.fullname','Register.created','Register.created','User.id','Register.status'),
			 		'order' => 'Register.created DESC',
			 		'limit' => 5
			 		

				);

			$this->Lecture->recursive = -1;
			$data =  $this->Lecture->find('all',$options);

			//ghi trang thai block 	
			if($data != null)
				{
					$i = 0;
					foreach ($data as $item) {
					$isBlock = $this->isBlock($item['User']['id']);
					$data[$i]['Block'] = $isBlock;
					$i++;

					}
				}
				
			$this->set('fiveNewestLecture', $data);
		
	//lay 5 bai ma hot nhat trong he thong
	//Cac bai co so like nhieu nhat trong vong ba thang ,den thoi diem hien tai

		$options = 	array(
					'joins' => array(
								    array('table' => 'lectures',
								        'alias' => 'Lecture',
								        'type' => 'inner',
								        'conditions' => array('Lecture.id = Favorite.lecture_id')
								    ),
								    array(
								    	'table' => 'users',
								    	'alias' => 'User',
								    	'type'  => 'inner',
								    	'conditions' => array('Lecture.user_id = User.id')
								    	)
			            
									),
					'group'  => 'Lecture.id',
					
			 		'fields' => array('Lecture.id','User.id', 'Lecture.name','Lecture.cost','User.fullname','count(Favorite.lecture_id)'),
			 		'order' => 'count(Favorite.lecture_id) DESC',
			 		'conditions' => array('Favorite.created >' => date('Y-m-d H:i:s',strtotime("-3 month"))),
			 		'limti' => 5

				);

			$this->loadModel('Favorite');
			$this->Favorite->recursive = -1;
			$data =  $this->Favorite->find('all',$options);
//Check block, status lecture
		
			
			if($data != null)
				{
					$i = 0;
					foreach ($data as $item) {
					$isBlock = $this->isBlock($item['User']['id']);
					$statusLecture = $this->getStatusLecture($item['Lecture']['id']);
					$data[$i]['Block'] = $isBlock;
					$data[$i]['statusLecture'] = $statusLecture;
					$i++;

					}
				}

			$this->set('fiveHotLectures' , $data);


	}

	public function topLecturesHot()
	{
		$this->set('menu_type','student_menu');
		$user_id = $this->Auth->user('id');
		$options = 	array(
					'joins' => array(
								    array('table' => 'lectures',
								        'alias' => 'Lecture',
								        'type' => 'inner',
								        'conditions' => array('Lecture.id = Favorite.lecture_id')
								    ),
								    array(
								    	'table' => 'users',
								    	'alias' => 'User',
								    	'type'  => 'inner',
								    	'conditions' => array('Lecture.user_id = User.id')
								    	)
			            
									),
					'group'  => 'Lecture.id',
					
			 		'fields' => array('Lecture.id', 'Lecture.name','Lecture.cost','User.id','User.fullname','count(Favorite.lecture_id)'),
			 		'order' => 'count(Favorite.lecture_id) DESC',
			 		'conditions' => array('Favorite.created >' => date('Y-m-d H:i:s',strtotime("-1 month"))),
			 		'limit' => 10

				);

			$this->loadModel('Favorite');
			$this->Favorite->recursive = -1;
			$this->paginate = $options;
			$data = $this->paginate('Favorite');


			$listBlock = $this->getListBlock();
				// ghi vao $data bien isBlock
				
				if($data != null)
					{
						$i = 0;
						foreach ($data as $item) {
						$isBlock = $this->checkBlock($item['User']['id'],$listBlock);
						$data[$i]['Block'] = $isBlock;
						$i++;

						}
					}

			$this->set('hotLectures' , $data);
			// lay danh sach cac bai ma user nay da dang ki
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

	public function getListBlock()
	{
	
		$user_id = $this->Auth->user('id');
		$this->loadModel('Block');
		$listBlock = $this->Block->find('all',
				array(
					'conditions' => array('Block.student_id' => $user_id)
					)
			);
		return $listBlock;
	}

	public function viewInfo(){
		$this->set('menu_type','student_menu');
		$user_id = $this->Auth->user('id');
		$this->loadModel('User');
		$info = $this->User->findById($user_id);
		$this->set("info",$info);
		$this->set("user_id", $user_id);
	}

	
	public function registedLectures()
	{
		//set menu
		$this->set('menu_type','student_menu');
		// lay hang so he thong



		
		$user_id = $this->Auth->User('id');
		$this->loadModel('Register');
	

		$options['joins'] = array(
					    array('table' => 'lectures',
					        'alias' => 'Lecture',
					        'type' => 'inner',
					        'conditions' => array('Lecture.id = Register.lecture_id' )),

					    array('table' => 'users',
					    	'alias' => 'User',
					    	'type' => 'inner',
					    	'conditions' => array('User.id = Lecture.user_id')
					    	),
					    array(
					    	'table' => 'tests',
					    	'alias' => 'Test',
					    	'type' => 'inner',
					    	'conditions' => array('Test.lecture_id = Lecture.id' )
					    	)
					    );
			

		$options['conditions'] = array('Register.user_id' => $user_id,
			'Register.status <>' => 3
			);
		$options['order'] = array(
					'Register.created ' => 'DESC' 
					);
		$options['fields'] =array('Lecture.id','Lecture.name','Test.id','Register.created','Lecture.cost','Register.status','User.id');
		$options['limit'] = 10;
		$this->Register->recursive = -1;

		$this->paginate = $options;

		$data = $this->paginate('Register');
		

		//// lay danh sach cac giao vien da block em:
			$listBlock = $this->getListBlock();
			// ghi vao $data bien isBlock
			
			if($data != null)
				{
					$i = 0;
					foreach ($data as $item) {
					$isBlock = $this->checkBlock($item['User']['id'],$listBlock);
					$data[$i]['Block'] = $isBlock;
					$i++;

					}
				}
				
			//Check xem da test chua :
				$this->loadModel('Result');
			if($data != null)
				{
					$i = 0;
					foreach ($data as $item) {
					$test_id = $item['Test']['id'];

					$temp = $this->Result->find('all',
						array(

							'conditions' => array('test_id' => $test_id,
										'user_id' => $user_id
								),
							'order' => 'Result.created DESC'

							)
						);
					if($temp == null)
						$data[$i]['isTest'] = 0;
					else 
					{
						$data[$i]['isTest'] = 1;
						$data[$i]['result_id'] = $temp[0]['Result']['id'];
					}
					
					$i++;

					}
				}
				


		$this->set('registedLectures',$data);


	}

	public function registerLecture($lecture_id = null, $backLink = null)
	{
		$this->set('menu_type','student_menu');
		$user_id = $this->Auth->user('id');
		if($lecture_id == NULL) $this->redirect(array("action" => 'index') );
		if(!isset($lecture_id)) $this->redirect(array("action" => 'index') );
		if(!isset($backLink)) $this->redirect(array("action" => 'index'));

		$data = array(
			'Register' =>array(	
					'user_id' => $user_id,
					'lecture_id' => $lecture_id,
					'status'  => 0
				)
			);
		$this->loadModel('Register');
	
		if (!($this->Register->updateAll(

		    array('Register.status' => 3),
		    array('Register.lecture_id' => $lecture_id)
		    
				)))
			{
				$this->Session->setFlash(_('システムエラー'));
				$this->redirect(array('action' => 'index'));
				return 0;

			}

		$this->Register->create();
		if($this->Register->save($data))
		{

			//log
					$this->loadModel('User');
					$data = $this->User->find('all',array(
		           	'conditions' => array('id' => $user_id),
		           'recursive' => -1)
		           	);
		           	
		           	$date = date('Y-m-d H:i:s');
		            $file = "register_lecture.txt";
		          //"順番", “SUCCESS”, "時間", "ユーザーID", "ユーザー名", "tuoi", “sdt”, “email”, “dia chi”
		            $content =  "\"SUCCESS\","."\"".$date."\","."\"".$data[0]['User']['id']."\","."\"".$data[0]['User']['username']."\",\"学生は講義に受ける\",\"".$lecture_id."\"";
		            
		            $this->Log->writeLog($file,$content);
			$this->redirect(array("action" => $backLink));
		}
		else 
			{
				$this->Session->setFlash(_('システムエラー'));
				$this->redirect(array('action' => 'index'));
			}
		

	}



	public function resultsStatistics()
		{
			$this->set('menu_type','student_menu');
			$user_id = $this->Auth->user('id');
			$this->loadModel('Result');
			$options['joins'] = array(
				array(
					'table' => 'tests',
					'alias' => 'Test',
					'type' => 'inner',
					'conditions' => array('Test.id = Result.test_id')

					),
				array(
					'table' => 'lectures',
					'alias' => 'Lecture',
					'type' => 'inner',
					'conditions' => array('Lecture.id = Test.lecture_id')
					),
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'conditions' => array('User.id = Lecture.user_id')
					),
				array(
					'table' => 'registers',
					'alias' => 'Register',
					'type' => 'inner',
					'conditions' => array('Register.lecture_id = Lecture.id')
					)
				);
			$options['limit'] = 10;
			$options['conditions'] = array('Result.user_id' => $user_id);
			$options['order'] = array('Result.created' => 'DESC');
			$options['fields'] =array('Result.id','Lecture.name','Register.created','User.id','Test.id','Lecture.id','Result.created','Result.score');
			$this->Result->recursive = -1;

			$this->paginate = $options;
			$data = $this->paginate('Result');
			
			//// lay danh sach cac giao vien da block em:
			$listBlock = $this->getListBlock();
			// ghi vao $data bien isBlock
			
			if($data != null)
				{
					$i = 0;
					foreach ($data as $item) {
					$isBlock = $this->checkBlock($item['User']['id'],$listBlock);
					$data[$i]['Block'] = $isBlock;
					$i++;

					}
				}
		

		    $this->set('results',$data);
			
		}
	public function lecturesStatistics()
	{
	//set menu
		$this->set('menu_type','student_menu');
	//lay hang so he thong
		$cost = 20000;
		$this->set('cost',$cost);


		$user_id = $this->Auth->user('id');
		$this->loadModel('Lecture');
		$this->loadModel('Register');

		$options=  array(
			'joins' => array(
	
						array(
							'table' => 'users',
							'alias' => 'User',
							'type' => 'inner',
							'conditions' => array("User.id = Lecture.user_id")

							)
					
						),
			'order' => array('Lecture.created' => 'ASC'),
			'limit' => 10,
			'fields' => array('Lecture.id','Lecture.cost','User.fullname','Lecture.name','User.id')
		);

		$this->Lecture->recursive = -1;
		$this->paginate = $options;
		$data = $this->paginate('Lecture');

//Check Block, status lecture

			
			if($data != null)
				{
					$i = 0;
					foreach ($data as $item) {
					$isBlock = $this->isBlock($item['User']['id']);
					$statusLecture = $this->getStatusLecture($item['Lecture']['id']);
					$data[$i]['Block'] = $isBlock;
					$data[$i]['statusLecture'] = $statusLecture;
					$i++;

					}
				}

	    $this->set('lectures',$data);


	    
	}
		
	public function editInfo($id = null){
		$this->set('menu_type','student_menu');
		$user_id = $this->Auth->user('id');
		$this->loadModel('User');
		$this->User->id =$user_id;

		if(!$this->User->exists()){
			throw new NotFoundException(__('不当なユーザ'));
		}

		if ($this->request->is('post') || $this->request->is('put')) { 
			$data = $this->request->data['User'] ;
		$data['date_of_birth'] = $data['date_of_birth']['month'].'-'.$data['date_of_birth']['day'].'-'.$data['date_of_birth']['year'];

		
			if ($this->User->save($this->request->data)) {
		            $this->Session->setFlash(__('情報は更新されていた'));

		           // ghi log
		           $data = $this->User->find('all',array(
		           	'conditions' => array('id' => $user_id),
		           'recursive' => -1)
		           	);
		           	
		           	$date = date('Y-m-d H:i:s');
		            $file = "user_change_info.txt";
		          //"順番", “SUCCESS”, "時間", "ユーザーID", "ユーザー名", "tuoi", “sdt”, “email”, “dia chi”
		            $content =  "\"SUCCESS\","."\"".$date."\","."\"".$data[0]['User']['id']."\","."\"".$data[0]['User']['username']."\",\"基本情報変更\"";
		            
		            $this->Log->writeLog($file,$content);

				//	return $this->redirect(array('action' => 'index')); 
		            return $this->redirect(array('action' => 'view_info'));
				}
				//log loi 
				// ghi log
		           $data = $this->User->find('all',array(
		           	'conditions' => array('id' => $user_id),
		           'recursive' => -1)
		           	);
		           	
		           	$date = date('Y-m-d H:i:s');
		            $file = "user_change_info.txt";
		          //"順番", “SUCCESS”, "時間", "ユーザーID", "ユーザー名", "tuoi", “sdt”, “email”, “dia chi”
		            $content =  "\"FAIL\","."\"".$date."\","."\"".$data[0]['User']['id']."\","."\"".$data[0]['User']['username']."\",\"基本情報変更\"";
		            
		            $this->Log->writeLog($file,$content);
		        $this->Session->setFlash(
		            __('エラーが起きてしまった。してみてください'));
		} else {
		$this->request->data = $this->User->read(null, $id);
		      //  unset($this->request->data['User']['password']);
		    }
	}

	public function calcMoney($month , $year )
	{
		//Tinh tien tu dau thang den ngay hien tai
		$user_id = $this->Auth->user('id');
		$this->loadModel('Register');
		$options = array(
					'conditions' => array(
						'Register.user_id' => $user_id,
						'MONTH(Register.created)' => $month,
						'YEAR(Register.created)' => $year
					),
					'fields' => array( 'count(Register.id) as money')
					

			);
		$data = $this->Register->find('all',$options);
		$money = $data[0][0]['money'] * 20000;
		
		return $money;
		


	}

	function checkBlock($teacher_id = null, $listBlock = null)
		{
		    // isBlock = 0 : ko bi block , if = 1 blocked.

		if($listBlock == null)
		    return 0;
		else
		{
			foreach ($listBlock as $item) {
				if($item['Block']['teacher_id'] == $teacher_id)
					{
						return 1;

					}
			    
			}

		}
		return 0;

		}
	
	public function delAccount()
	{
		$this->set('menu_type','student_menu');
		if($this->request->is('post') || $this->request->is('put')){
					$user_id = $this->Auth->user('id');
					$this->loadModel('User');
					$data = $this->calc_money();
					$money = $data[0][0]['money'];
					if ($money == null||$money == 0) {
						// du dieu kien xoa tai khoan
						$data = array('id' => $user_id, 'state' => 'deleted');
						// This will update Recipe with id 10
						if($this->User->save($data))
						{
								//log
					$data = $this->User->find('all',array(
		           	'conditions' => array('id' => $user_id),
		           'recursive' => -1)
		           	);
		           	
		           	$date = date('Y-m-d H:i:s');
		            $file = "delete_account.txt";
		          //"順番", “SUCCESS”, "時間", "ユーザーID", "ユーザー名", "tuoi", “sdt”, “email”, “dia chi”
		            $content =  "\"SUCCESS\","."\"".$date."\","."\"".$data[0]['User']['id']."\","."\"".$data[0]['User']['username']."\",\"アカウントを削除\"";
		            
		            $this->Log->writeLog($file,$content);
							$this->Session->setFlash(_('アカウントは削除した'));
							$this->redirect($this->Auth->logout());
						}
						else 
							{
								$this->Session->setFlash(_('システムエラー'));
								$this->redirect(array('action' => 'index'));
							}
					}
					else
					{
						// de xoa tai khoan ban can thanh toan het tien
						$this->Session->setFlash(__('アカウントを削除できるように、残りの費用を支払っておいてください'));
						$this->redirect(array('action' => 'index'));
					}
			}

		
	}


public function testSubQueryAndPaging(){

$conditionsSubQuery['User2.id'] = '29';
$this->loadModel('User');
$db = $this->User->getDataSource();
$subQuery = $db->buildStatement(
    array(
        'fields'     => array('User2.id'),
        'table'      => $db->fullTableName($this->User),
        'alias'      => 'User2',
        'limit'      => null,
        'offset'     => null,
        'joins'      => array(),
        'conditions' => $conditionsSubQuery,
        'order'      => null,
        'group'      => null
    ),
    $this->User
);
$subQuery = 'User.id NOT IN (' . $subQuery . ') ';
$subQueryExpression = $db->expression($subQuery);

$conditions[] = $subQueryExpression;

$this->User->recursive = -1;

$options = compact('conditions');
$options['limit'] = 2;
			$this->paginate = $options;
			 $data = $this->paginate('User');

// $this->User->find('all', compact('conditions'));
$this->set('data', $data);

}

public function registedLectureThisWeek(){
	// set menu
	$this->set('menu_type', 'student_menu');
	//hang so he thong
	$cost = 20000;

	$user_id = $this->Auth->User('id');
	$options['joins'] = array(
					    array('table' => 'lectures',
					        'alias' => 'Lecture',
					        'type' => 'inner',
					        'conditions' => array('Lecture.id = Register.lecture_id' )),

					    array('table' => 'users',
					    	'alias' => 'User',
					    	'type' => 'inner',
					    	'conditions' => array('User.id = Lecture.user_id')
					    	)
					       );
	$options['conditions'] = array('Register.user_id' => $user_id,
			'Register.created >=' => date('Y-m-d H:i:s',strtotime("-1 weeks"))

			);
		$options['order'] = array(
					'Register.created ' => 'DESC' 
					);
		$options['fields'] =array('Lecture.id','Lecture.name','Register.created','Register.id','Lecture.cost','Register.status','User.id');
		$options['limit'] = 10;
		$this->loadModel('Register');
		$this->Register->recursive = -1;

		$this->paginate = $options;

		$data = $this->paginate('Register');

		if($data != null)
						{
							$i = 0;
							foreach ($data as $item) {
							$isBlock = $this->isBlock($item['User']['id']);
							$statusTest = $this->getStatusTest($item['Register']['id']);
							$data[$i]['Block'] = $isBlock;
							$data[$i]['StatusTest'] = $statusTest;
							$i++;

							}
						}


	$this->set('registedLectureThisWeek',$data);
	$this->set('cost',$cost);


}


public function moneyStatistics(){



    $this->set('menu_type','student_menu');
    $user_id = $this->Auth->user('id');

    if($this->request->is('post')) {

    $month=$this->request->data['Money']['mos'];
    $year=$this->request->data['Money']['yos'];

 	$this->Session->write('monthxu', $month);
 	$this->Session->write('yearxu', $year);

   
     }
    else
    {

    	if((!$month = $this->Session->read('monthxu')) || (!$year = $this->Session->read('yearxu')))
    	{
    	$month = date('n');
	 	$year = date('Y');
    	}


		
    }

    //Tinh tien thang da chon
    $moneyOfTheMonth = $this->calcMoney($month,$year);

   	//Phan trang cac bai da hoc cua thang da chon
   	$this->loadModel('Register');

		$options['joins'] = array(
					    array('table' => 'lectures',
					        'alias' => 'Lecture',
					        'type' => 'inner',
					        'conditions' => array('Lecture.id = Register.lecture_id' )),

					    array('table' => 'users',
					    	'alias' => 'User',
					    	'type' => 'inner',
					    	'conditions' => array('Lecture.user_id = User.id')
					    	)


					    );
			

		$options['conditions'] = array('Register.user_id' => $user_id,
			'MONTH(Register.created)  ' => $month,
			'YEAR(Register.created) ' => $year

			);

		$options['fields'] =array('Lecture.id as id','Lecture.name as title','User.fullname as fullname','Register.created as time');
		$options['limit'] = 10;
		$this->Register->recursive = -1;

		$this->paginate = $options;
		$data = $this->paginate('Register');
		
		if($data != null) 	$this->set('lecturesOfTheMonth',$data);
		$this->set('moneyOfTheMonth',$moneyOfTheMonth);
		//Lay gia tien mot bai hoc tu hang so he thong
		$this->set('cost','20.000 VND');



	if(($montharr = $this->Session->read('monthxu')) && ($yeararr = $this->Session->read('yearxu')))
	{
		 $month = intval($montharr['month']);
		 $year = intval($yeararr['year']);
	     $this->set("mos",$month);
	     $this->set("yos",$year);
	}
	else
	{
		 $currentMonth = date('n');
	  	 $currentYear = date('Y');
	     $this->set("mos",$currentMonth);
	     $this->set("yos",$currentYear);
	}
  


	}

public function isBlock($teacher_id = null){

if($teacher_id == null ) 
		{
				$this->Session->setFlash(_('システムエラー.見つけない'));
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



public function	getStatusTest($register_id = null){
/* 
		-> ko co bai test  return 0
		-> co bai test
				-> chua test return 1
				-> test roi return  2

*/
if($register_id == null ) 
		{
				$this->Session->setFlash(_('システムエラー, 見つけない'));
				$this->redirect(array('action' => 'index'));
		}

$student_id = $this->Auth->user('id');
$this->loadModel('Register');
$this->loadModel('Test');



// co test ko?
$options['joins'] = array(
				array(
					'table' => 'lectures',
					'alias' => 'Lecture',
					'type' => 'inner',
					'conditions' => array('Lecture.id = Register.lecture_id')

					),
				array(
					'table' => 'tests',
					'alias' => 'Test',
					'type' => 'inner',
					'conditions' => array('Lecture.id = Test.lecture_id')
					),
			
				);

$options['conditions'] = array('Register.id' => $register_id);

$this->Register->recursive = -1;
$data =	$this->Register->find('all',$options);

//If bai nay ko co test di kem
if($data == null ){

	return 0;
}
//Neu bai nay co test di kem
else
{

	$sql = "SELECT * FROM registers, results WHERE registers.id = results.register_id AND results.created > registers.created AND registers.id = ".$register_id;
	$data = $this->Register->query($sql);


	//chua tham gia test
	if($data == null)
	{
		return 1;
	}
	else return 2;
}


}

public function getStatusLecture($lecture_id = null){
/* 
- Chua dang ki return 0
- Dang ki
		- chua hoc return 1
		- da hoc return 2

*/	if($lecture_id == null ) 
		{
				$this->Session->setFlash(_('システムエラー.見つけない'));
				$this->redirect(array('action' => 'index'));
		}
	$user_id = $this->Auth->user('id');
	$options = array(
	 	'conditions' => array('Register.lecture_id' => $lecture_id,
	 	'Register.user_id' => $user_id,
		'Register.created >=' => date('Y-m-d H:i:s', strtotime("-1 weeks"))
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
