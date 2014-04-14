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
		$COST = 20000;
		$this->set('COST',$COST);
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
											
					
			 		'fields' => array('Lecture.id', 'Lecture.name','User.fullname','Register.created','Register.created','User.id','Register.status'),
			 		'order' => array('Register.created' => 'DESC'),
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
					
			 		'fields' => array('Lecture.id','User.id', 'Lecture.name','User.fullname','count(Favorite.lecture_id) as iine'),
			 		'order' => array('iine' => 'DESC'),
			 		'conditions' => array('Favorite.created >' => date('Y-m-d H:i:s',strtotime("-3 month"))),
			 		'limit' => 5

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
		// tinh do hot dua vao so lan like trong 3 thang tro lai day
		$this->set('menu_type','student_menu');
		// load hang so he thong
		$COST = 20000;
		$this->set('COST',$COST);
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
					
			 		'fields' => array('Lecture.id', 'Lecture.name','User.id','User.fullname','count(Favorite.lecture_id) as iine'),
			 		'order' => 'iine DESC',
			 		'conditions' => array('Favorite.created >' => date('Y-m-d H:i:s',strtotime("-3 month"))),
			 		'limit' => 5

				);

			$this->loadModel('Favorite');
			$this->Favorite->recursive = -1;
			$this->paginate = $options;
			$data = $this->paginate('Favorite');

			// ghi trang thai dang ki chua, co bi block ko
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

		

			$this->set('hotLectures', $data);
		
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
		// set menu
		$this->set('menu_type', 'student_menu');
		//hang so he thong
		$COST = 20000;
		$this->set('COST',$COST);
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
		$options['conditions'] = array('Register.user_id' => $user_id	);
		$options['order'] = array(
					'Register.created ' => 'DESC' 
					);
		$options['fields'] =array('Lecture.id','Lecture.name','Register.created','Register.id','Register.status','User.id');
		$options['limit'] = 5;
		$this->loadModel('Register');
		$this->Register->recursive = -1;

		$this->paginate = $options;

		$data = $this->paginate('Register');

		
	$this->set('registedLectures',$data);
	


	}

	public function registerLecture($lecture_id = null, $backLink = null)
	{
		$this->set('menu_type','student_menu');
		// if ($this->request->is('post')) { 
		// 	debug($this->request->data); die;
		
		// }
	if ($this->request->is('post'))
	{	
		$user_id = $this->Auth->user('id');
		$lecture_id = $this->request->data['Lecture']['lecture_id'];
		$backLink = $this->request->data['Lecture']['backLink'];
	
		if($lecture_id == NULL) $this->redirect(array("action" => 'index') );

		//Neu ma bi Block
		if(($this->checkBlockByLectureID($lecture_id)) == 0)
		{

			
			if($this->getStatusLecture($lecture_id) == 0)
			{
				$data = array(
					'Register' =>array(	
							'user_id' => $user_id,
							'lecture_id' => $lecture_id,
							'status'  => 0
						)
					);
				$this->loadModel('Register');
			
		
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
							$this->Session->setFlash(_('登録が成功しました'));
				if($backLink == null)	$this->redirect(array('action' => 'index'));	
				else $this->redirect(array('action' => $backLink));
			
				}
				else 
					{
						$this->Session->setFlash(_('システムエラー'));
						$this->redirect(array('action' => 'index'));
					}
			} else {
				$this->Session->setFlash(_('この講義は前に登録しました'));
					$this->redirect(array('action' => 'index'));
				}
		}
		else
		{
		$this->Session->setFlash(_('あなたは今、この先生にブロックられています'));
		if($backLink == null)	$this->redirect(array('action' => 'index'));	
		else $this->redirect(array('action' => $backLink));

		}
	
	}
}

	public function lecturesStatistics()
	{
	//set menu
		$this->set('menu_type','student_menu');
	//lay hang so he thong
		$COST = 20000;
		$this->set('COST',$COST);

		$catagory = "0";
		if ($this->request->is('post'))
		{	
		$catagory = $this->request->data['Students']['catagory'];
		}
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
			'limit' => 5,
			//'conditions' =>array('Lecture.category_id' => "$catagory"),
			'fields' => array('Lecture.id','User.fullname','Lecture.name','User.id')
		);
		if($catagory != "0") $options['conditions'] = array('Lecture.category_id' => $catagory);
		//debug($options);
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
		            return $this->redirect(array('action' => 'viewInfo'));
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

	// function checkBlock($teacher_id = null, $listBlock = null)
	// 	{
	// 	    // isBlock = 0 : ko bi block , if = 1 blocked.

	// 	if($listBlock == null)
	// 	    return 0;
	// 	else
	// 	{
	// 		foreach ($listBlock as $item) {
	// 			if($item['Block']['teacher_id'] == $teacher_id)
	// 				{
	// 					return 1;

	// 				}
			    
	// 		}

	// 	}
	// 	return 0;

	// 	}
	
	public function delAccount()
	{
		$this->set('menu_type','student_menu');
		if($this->request->is('post') || $this->request->is('put')){
					$user_id = $this->Auth->user('id');
					$this->loadModel('User');
					$month = date('n');
 					$year = date('Y');
					$money = $this->calcMoney($month,$year);
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
	$COST = 20000;
	$this->set('COST',$COST);

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
		$options['fields'] =array('Lecture.id','Lecture.name','Register.created','Register.id','Register.status','User.id');
		$options['limit'] = 5;
		$this->loadModel('Register');
		$this->Register->recursive = -1;

		$this->paginate = $options;

		$data = $this->paginate('Register');

		if($data != null)
						{
							$i = 0;
							foreach ($data as $item) {
							$isBlock = $this->isBlock($item['User']['id']);
							$hasTest = $this->lectureHasTest($item['Register']['id']);
							$data[$i]['Block'] = $isBlock;
							$data[$i]['HasTest'] = $hasTest;
							$i++;

							}
						}


	$this->set('registedLectureThisWeek',$data);
	


}

//------xuan----2014/4/9 
	//hien thi chi tiet bai giang

	public function detailLecture($id = null, $backLink = null)
	{
		// set menu
		$this->set('menu_type','student_menu');
		//lay hang he thong
		$COST = 20000;
		$this->set('COST',$COST);
		if($id == null) 
		{
			if($currentLocation != null)
				{
				$this->Session->setFlash(__('すみません,見つけられない!'));
				return $this->redirect(array('controller'=>'students','action' => $backLink));
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
		$this->set('comments', $this->Lecture->Comment->findAllByLectureId($id));
		// Tang so lan tham khao bai giang :
		//khi sua thi xoa het di
		//$this->Lecture->recursive = -1;
		$data = $this->Lecture->findById($id);
		$this->set('num_liked',count($data['Favorite']));
		if($data != null )
		{

			$refer_times = $data['Lecture']['refer_times'] + 1;
			$this->Lecture->id = $id;
			$this->Lecture->saveField('refer_times', $refer_times);
			
		}

		//----------------- ket thuc doan xu ly tang luot tham khao them 1
		$options['joins'] = array(
					    array('table' => 'users',
					        'alias' => 'User',
					        'type' => 'inner',
					        'conditions' => array('Lecture.user_id = User.id' )));
			

		$options['conditions'] = array('Lecture.id' => $id);
		$options['fields'] =array('Lecture.id','Lecture.name','User.fullname','User.id','User.username','User.mobile_No','User.mail','Lecture.description');
 		$this->Lecture->recursive = -1;

 		$data = $this->Lecture->find('all',$options);
 		$user_id = $this->Auth->user('id');
 		if($data != null)
		{
 		// kiem tra bi block ko

			$i = 0;
			foreach ($data as $item) {
			$isBlock = $this->isBlock($item['User']['id']);
			$statusLecture = $this->getStatusLecture($item['Lecture']['id']);
			$data[$i]['Block'] = $isBlock;
			$data[$i]['statusLecture'] = $statusLecture;
			$i++;

			}
			$this->set('lecture',$data);
 		}

		}
		$this->set('backLink', $backLink);


	}
	//___________--

public function moneyStatistics(){


	//set menu
    $this->set('menu_type','student_menu');
    // Lay hang he thong
    $COST = 20000;
    $this->set('COST',$COST);
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
		$options['limit'] = 5;
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

public function viewListTest($register_id = null)
{
		if($this->Auth->user('role')=='student')
			$this->set('menu_type','student_menu');
		elseif($this->Auth->user('role')=='teacher')
			$this->set('menu_type','teacher_menu');
		else
			$this->set('menu_type','manager_menu');


	//check block
	$this->loadModel('Register');
	$this->loadModel('Lecture');
	$flag = 0;
	$this->Register->recursive = -1;
	$this->Lecture->recursive = -1;
	$register = $this->Register->findAllById($register_id);
	
	if($register == null ) $flag = 1;
	else
	{
		$lecture = $this->Lecture->findAllById($register[0]['Register']['lecture_id']);
		
		if($lecture == null) $flag = 1;
		else
			$isBlock = $this->isBlock($lecture[0]['Lecture']['user_id']);
	}
	//Khong tim thay register_id
	if($flag == 1)
	{
		$this->set('exist',0);
				return 0;
	}
	else
	
		$this->set('exist',1);

	
	//--------------------
	if((!$this->checkPermissionLecture($register_id))||($isBlock == 1))
	{
		$this->set('permission',0);
		return 0; 
	}
	else
	{
			$this->set('permission',1);

			$user_id = $this->Auth->user('id');
			$student_id = $this->Auth->user('id');
			$this->loadModel('Register');


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
			$options['fields'] = array('Register.id','Test.id','Test.name','Lecture.id','Lecture.name');
			$options['conditions'] = array('Register.id' => $register_id);

			$this->Register->recursive = -1;
			$data =	$this->Register->find('all',$options);
			//ko co test
			if($data == null) {
				$this->set('hasTest',0);
				return 0;	}
			//co test
			else
			{
				$this->loadModel('Result');
				$this->set('hasTest',1);

				// da test chua
				$i = 0;
				foreach ($data as $test) {
					//Neu da tung test bai nay thi lay ket qua moi nhat
					$options = array(
						'conditions' => array('Result.test_id' => $data[$i]['Test']['id'], 'Result.user_id'=>$this->Auth->user('id')),
						'order' => array('Result.created' => 'DESC'),
						'limit' => 1
							
						);
					$resultData = $this->Result->find('all',$options);
					if($resultData == null)
					{
						$data[$i]['HasResult'] = 0;

					}
					else
					{
						$data[$i]['HasResult'] = 1;
						$data[$i]['Result_id'] = $resultData[0]['Result']['id'];
					}
					$i++;
				}
			}
		$this->set('data',$data);

	}


}

public function isBlock($teacher_id = null){
// 0 la ko block
// 1 la block
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



public function	lectureHasTest($register_id = null){
/* 
		-> ko co bai test  return 0
		-> co bai test  return 1
				

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
return 1;


}
public function checkPermissionLecture($register_id = null ){

//Nguoi dung hien tai co dang ki bai nay trong 1 tuan ko?
	$user_id = $this->Auth->user('id');
	$this->loadModel('Register');
	$this->Register->recursive = -1;
	$options = array(
		'conditions' => array('Register.id' => $register_id,
			'Register.created >=' => date('Y-m-d H:i:s', strtotime("-1 weeks")),
			'Register.user_id' => $user_id

			)

		);
	$data = $this->Register->find('all',$options);
	if($data == null) return 0;
	else return 1;

}

public function getStatusLecture($lecture_id = null){
/* 
- Chua dang ki return 0
- Da dang ki trong vong mot tuan
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
