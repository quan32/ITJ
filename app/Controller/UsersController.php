<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('CakeTime', 'Utility');
class UsersController extends AppController{

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('login', 'role', 'verify1','verify2','manager_login');
	}
	public function isAuthorized($user){
		// Everyone can access
		return true;
	}

	public function view($id = null){
		$this->set('menu_type','menu');
		$this->User->id = $id;
		if(!$this->User->exists())
			throw new NotFoundException(__('不当なユーザ'));

		$this->set('user', $this->User->read(null, $id));
	}

	public function edit($id = null){
		$this->set('menu_type','menu');
		$this->User->id =$id;
		if(!$this->User->exists()){
			throw new NotFoundException(__('不当なユーザ'));
		}

		if ($this->request->is('post') || $this->request->is('put')) { 
			if ($this->User->save($this->request->data)) {
		            $this->Session->setFlash(__('アカウントはデータベースに保存されていた'));
					return $this->redirect(array('action' => 'index')); 
				}
		        $this->Session->setFlash(
		            __('アカウントは保存できなかった。してみてください。'));
		} else {
			$this->request->data = $this->User->read(null, $id);
		        unset($this->request->data['User']['password']);
		    }

	}

	public function delete($id =null){
			$this->loadModel('Vovan');
			$this->loadModel('Report');
			$this->loadModel('Message');
			$this->loadModel('Favorite');
			$this->loadModel('Comment');
			$this->loadModel('Block');
			$this->loadModel('Register');
			$this->loadModel('Test');
			$this->loadModel('Result');
			$this->loadModel('TsvFile');
			$this->loadModel('Source');
			$this->loadModel('Lecture');


			$this->User->id = $id;
			if(!$this->User->exists())
				throw new NotFoundException(__('このアカウントは存在していない'));
            $user=$this->User->findById($id);
            $user_id=$user['User']['id'];

            if($user['User']['role']=="teacher"){
	            $lectures = $user['Lecture'];
	            if($lectures){
		            //Xoa cac thong tin lien quan toi bai giang cua user
		            foreach ($lectures as $lecture) {
		            	$lecture_id = $lecture['id'];

		            	//Xoa cac lien ket toi tag
		            	$this->Vovan->deleteAll(array('lecture_id'=>$lecture_id));
		            	//Xoa cac report
		            	$this->Report->deleteAll(array('user_id'=>$user_id));
		            	$this->Report->deleteAll(array('lecture_id'=>$lecture_id));
		            	//Xoa cac message
		            	$this->Message->deleteAll(array('user_id'=>$user_id));
		            	$this->Message->deleteAll(array('lecture_id'=>$lecture_id));
		            	//Xoa cac like
		            	$this->Favorite->deleteAll(array('user_id'=>$user_id));
		            	$this->Favorite->deleteAll(array('lecture_id'=>$lecture_id));
		            	//Xoa cac comment
		            	$this->Comment->deleteAll(array('user_id'=>$user_id));
		            	$this->Comment->deleteAll(array('lecture_id'=>$lecture_id));
		            	//Xoa cac block
		            	$this->Block->deleteAll(array('teacher_id'=>$user_id));
		            	//Xoa cac register
		            	$this->Register->deleteAll(array('lecture_id'=>$lecture_id));

		            	$tests = $this->Test->findAllByLectureId($lecture_id);
		            	if($tests){
			            	foreach ($tests as $test) {
			            		$test_id = $test['Test']['id'];

			            		//Xoa cac result
			            		$this->Result->deleteAll(array('user_id'=>$user_id));
			            		$this->Result->deleteAll(array('test_id'=>$test_id));

			            		//Xoa cac file tsv cua test
			            		$tsvFile = $this->TsvFile->findByTestId($test_id);
			            		if($tsvFile){
				            		$target=$tsvFile['TsvFile']['name'];
									$target='files/'. $target;

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
				            	

								//Xoa cac record file test trong tsv_files
								$this->TsvFile->delete(array('test_id'=>$test_id));

								//Delete test
								$this->Test->delete($test_id);
			            	}
		            	}


		            	//Xoa sources cua lecture
		            	$sources = $this->Source->findAllByLectureId($lecture_id);
		            	if($sources){
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
		            	}
		            	//Delete sources in database
						$this->Source->deleteAll(array('lecture_id'=>$lecture_id));      

		            }

	            }
	            //Delete lectures
	            $this->Lecture->deleteAll(array('user_id'=>$user_id));
            }elseif($user['User']['role']=="student"){
            	
            	$this->Result->deleteAll(array('user_id'=>$user_id));
            	$this->Report->deleteAll(array('user_id'=>$user_id));
            	$this->Message->deleteAll(array('user_id'=>$user_id));
            	$this->Favorite->deleteAll(array('user_id'=>$user_id));
            	$this->Comment->deleteAll(array('user_id'=>$user_id));
            	$this->Block->deleteAll(array('student_id'=>$user_id));
            	foreach ($user['Register'] as $register) {
            		$this->Register->id=$register['id'];
            		$this->Register->delete();
            	}
            }
            

            //Delete user
            if($this->User->delete()){
            	$date = date('Y-m-d H:i:s');
		        $file = "delete_account.txt";
		          //"順番", “SUCCESS”, "時間", "ユーザーID", "ユーザー名", "tuoi", “sdt”, “email”, “dia chi”
		        $content =  "\"SUCCESS\","."\"".$date."\","."\"".$user['User']['id']."\","."\"".$user['User']['username']."\",\"アカウントを削除\"";
		        $this->Log->writeLog($file,$content);
            	$this->Session->setFlash(__('アカウントは削除した'));
            	
				if($this->Auth->user('role')!='manager') // tu dong out khi tu xoa
					return $this->redirect($this->Auth->logout());
                if ($user["User"]["role"]=='teacher') {
                 	return $this->redirect(array('controller'=>'manages','action'=>'teacher'));
                 } 
                 if ($user["User"]["role"]=='student') {
                 	return $this->redirect(array('controller'=>'manages','action'=>'index'));
                 } 
                  if ($user["User"]["role"]=='manager') {
                 	return $this->redirect(array('controller'=>'manages','action'=>'manager'));
                 }
            }

			
			$this->Session->setFlash(__('アカウントはまだ削除されていなかった'));
				if($this->Auth->user('role')=='teacher')
					return $this->redirect(array('controller'=>'teachers','action'=>'index'));
				elseif($this->Auth->user('role')=='student')
					return $this->redirect(array('controller'=>'students','action'=>'index'));
				elseif($this->Auth->user('role')=='manager')
					{
		                 if ($user["User"]["role"]=='teacher') {
		                 	return $this->redirect(array('controller'=>'manages','action'=>'teacher'));
		                 } 
		                 if ($user["User"]["role"]=='student') {
		                 	return $this->redirect(array('controller'=>'manages','action'=>'index'));
		                 } 
		                  if ($user["User"]["role"]=='manager') {
		                 	return $this->redirect(array('controller'=>'manages','action'=>'manager'));
		                 }

					}

	}
	public function manager_login() {
		//$this->layout = false;
		$this->set('menu_type','empty');
		// Check session
		if($this->Auth->loggedIN() && $this->Auth->user('state')=="normal"){
			if($this->Auth->user('role')=='manager')
					return $this->redirect(array('controller'=>'manages','action'=>'index'));
				elseif($this->Auth->user('role')=='teacher')
					return $this->redirect(array('controller'=>'teachers','action'=>'index'));
				elseif($this->Auth->user('role')=='student')
					return $this->redirect(array('controller'=>'students','action'=>'index'));
			}
		if($this->request->is('post')){

			$IP = $this->request->clientIp();
			//var_dump($IP);die;

			if($user=$this->User->findByUsername($this->request->data['User']['username'])){
				$passwordHasher = new SimplePasswordHasher();
				$password = $passwordHasher->hash($this->request->data['User']['password']);
				
				//Check user's state
				if($password == $user['User']['password']){
					if($user['User']['role']=='teacher'){
						$this->Session->setFlash(__('あなたは管理者ではない。他のログイン画面を使ってください'));
						return $this->redirect(array('action'=>'manager_login'));
					}elseif ($user['User']['role']=='student') {
						$this->Session->setFlash(__('あなたは管理者ではない。他のログイン画面を使ってください'));
						return $this->redirect(array('action'=>'manager_login'));
					}else{//Xu ly dang nhap cho manager
						if($user['User']['state']=='deleted'){//Tai khoan da bi khoa
							$this->Session->setFlash(__('アカウントは削除されたから、貴方は管理権が失ってしまった。'));
							$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 削除したアカウントでログインした';
							$this->Log->writeLog('login.txt',$log);
							return $this->redirect(array('action'=>'login'));
						}

						$count=0;

						//debug($user);die;
						//debug($IP); die;
						foreach ($user['Ip'] as $ip) {
							if($ip['ip']==$IP)
								$count++;
						}
						//$count=1;
						if($count==0){
							$this->Session->setFlash(__('間違ったIPアドレス'));
							$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', このIPアドレスはIPアドレスリストにない';
							$this->Log->writeLog('login.txt',$log);
							return $this->redirect(array('action'=>'login'));
						}
					}
					
				}

				if($this->Auth->login()){
					$log="INFO, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', ログインした成功して登録した';
					$this->Log->writeLog('login.txt',$log);
					$this->Session->setFlash('ログインした');
					$this->User->id=$user['User']['id'];
					$this->User->saveField('failedNo',0);
					
					if($this->Auth->user('role')=='manager')
						return $this->redirect(array('controller'=>'manages','action'=>'index'));
					elseif($this->Auth->user('role')=='teacher')
						return $this->redirect(array('controller'=>'teachers','action'=>'index'));
					else
						return $this->redirect(array('controller'=>'students','action'=>'index'));
					}
				else{
					$this->Session->setFlash(__('ユーザ名又はパスワードが間違ってしまった'));
					$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 第'.($user['User']['failedNo']+1).'回：ユーザ名又はパスワードが間違ってしまった';
					$this->Log->writeLog('login.txt',$log);
					}
	
				}else{
					$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', アカウントが存在していない';
					$this->Log->writeLog('login.txt',$log);
					$this->Session->setFlash(__('アカウントは存在していない。新規アカウントを登録してください。'));
					}	
		}
		
		}
	public function login(){
		$this->layout = false;
		$max = $this->Constant->findByName('MAX');
		$max = $max['Constant']['value'];//so lan dang nhap that bai thi bi khoa tai khoan tam thoi

		$blockTime = $this->Constant->findByName('blockTime');
		$blockTime = $blockTime['Constant']['value'];
		$time=$blockTime;//7200(s)=2(h)

		// debug($max);die;
		$this->set('menu_type','empty');

		// Check session
		if($this->Auth->loggedIN() && $this->Auth->user('state')=="normal"){
			if($this->Auth->user('role')=='manager')
					return $this->redirect(array('controller'=>'manages','action'=>'index'));
				elseif($this->Auth->user('role')=='teacher')
					return $this->redirect(array('controller'=>'teachers','action'=>'index'));
				elseif($this->Auth->user('role')=='student')
					return $this->redirect(array('controller'=>'students','action'=>'index'));
			}

		// If there is not session -> check usrname & password -> create session

		if($this->request->is('post')){

			$IP = $this->request->clientIp();
			//var_dump($IP);die;

			if($user=$this->User->findByUsername($this->request->data['User']['username'])){
				$passwordHasher = new SimplePasswordHasher();
				$password = $passwordHasher->hash($this->request->data['User']['password']);
				
				//Check user's state
				if($password == $user['User']['password']){
					if($user['User']['role']=='teacher'){
						if($user['User']['state']=='new'){//Trang thai moi dang nhap dang cho xac nhan
							$this->Session->setFlash(__('管理者からの許可をもっていないアカウント。後で戻ってください'));
							$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 管理者の同意を取ってないアカウントでログインした';
							$this->Log->writeLog('login.txt',$log);
							return $this->redirect(array('action'=>'login'));
						}elseif($user['User']['state']=='rejected'){//Trang thai moi dang nhap dang cho xac nhan
							$this->Session->setFlash(__('管理者に登録する要求を拒否させられてしまった。'));
							$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 管理者に登録する要求を拒否させられてしまったアカウントでログインした';
							$this->Log->writeLog('login.txt',$log);
							return $this->redirect(array('action'=>'login'));
						}elseif ($user['User']['state']=='blocked') {//Trang thai bi khoa tam thoi do qua 3 lan dang nhap that bai
							$time_now = intval(strtotime(date('H:i:s d-m-Y')));
  							$temp_time = intval(strtotime($user['User']['modified']));
  							$distance_time = $time_now - $temp_time;

							if($distance_time > $time){
								$this->User->id=$user['User']['id'];
								$this->User->saveField('failedNo',0);
								$this->Session->setFlash(__('アカウントはブロックする時間を過ごした。ログインできるように、確認するコードを入力してください'));
								$log="INFO, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', アカウントはアンブロックしたばかりだ';
								$this->Log->writeLog('login.txt',$log);
								return $this->redirect(array('controller'=>'users','action'=>'verify1',$user['User']['id']));
							}else{
								$this->Session->setFlash(__('アカウントは一時にブロックされている'));
								$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', ブロックしたアカウントでログインした';
								$this->Log->writeLog('login.txt',$log);
							return $this->redirect(array('action'=>'login'));
							}			
						}elseif($user['User']['state']=='deleted'){//Tai khoan da bi khoa
							$this->Session->setFlash(__('削除したアカウント。新規アカウントを作ってください'));
							$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 削除したアカウントでログインした';
							$this->Log->writeLog('login.txt',$log);
							return $this->redirect(array('action'=>'login'));
						}elseif($user['User']['state']=='locked'){//Tai khoan da bi khoa
							$this->Session->setFlash(__('ロックされているアカウント。アンロックするように、管理者へ連絡してください'));
							$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', ロックされているアカウント。アンロックするように、管理者へ連絡してください';
							$this->Log->writeLog('login.txt',$log);
							return $this->redirect(array('action'=>'login'));
						}elseif($user['User']['prevIP']!=$IP && $user['User']['prevIP']!=null){//Dia chi Ip su dung khac voi lan su dung truoc
							$this->Session->setFlash(__('前回使用したIPアドレスに違ったから、確認するコードを入力してください'));
							$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 前回使用したIPアドレスに違うIPアドレスでログインした';
							$this->Log->writeLog('login.txt',$log);
							return $this->redirect(array('controller'=>'users','action'=>'verify2',$user['User']['id'], $IP));
							}
						
					}elseif ($user['User']['role']=='student') {
						if($user['User']['state']=='new'){//Trang thai moi dang nhap dang cho xac nhan
							$this->Session->setFlash(__('管理者からの許可をもっていないアカウント。後で戻ってください'));
							$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 管理者の同意を取ってないアカウントでログインした';
							$this->Log->writeLog('login.txt',$log);
							return $this->redirect(array('action'=>'login'));
						}elseif($user['User']['state']=='rejected'){//Trang thai moi dang nhap dang cho xac nhan
							$this->Session->setFlash(__('管理者に登録する要求を拒否させられてしまった。'));
							$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 管理者に登録する要求を拒否させられてしまったアカウントでログインした';
							$this->Log->writeLog('login.txt',$log);
							return $this->redirect(array('action'=>'login'));
						}elseif ($user['User']['state']=='blocked') {//Trang thai bi khoa tam thoi do qua 3 lan dang nhap that bai
							$time_now = intval(strtotime(date('H:i:s d-m-Y')));
  							$temp_time = intval(strtotime($user['User']['modified']));
  							$distance_time = $time_now - $temp_time;

							if($distance_time > $time){
								$this->User->id=$user['User']['id'];
								$this->User->saveField('failedNo',0);
								$this->User->saveField('state','normal');
								$this->Session->setFlash(__('ブロックする時間を過ごしたばかりです。もう一度ログインしてください。'));
								$log="INFO, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', アカウントはアンブロックしたばかりだ';
								$this->Log->writeLog('login.txt',$log);
								return $this->redirect(array('action'=>'login'));
							}else{
								$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', ブロックしたアカウントでログインした';
								$this->Log->writeLog('login.txt',$log);
								$this->Session->setFlash(__('アカウントは一時にブロックされている'));
								return $this->redirect(array('action'=>'login'));
							}			
						}elseif($user['User']['state']=='locked'){//Tai khoan da bi khoa
							$this->Session->setFlash(__('ロックされているアカウント。アンロックするように、管理者へ連絡してください'));
							$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', ロックされているアカウント。アンロックするように、管理者へ連絡してください';
							$this->Log->writeLog('login.txt',$log);
							return $this->redirect(array('action'=>'login'));
						}elseif($user['User']['state']=='deleted'){//Tai khoan da bi khoa
							$this->Session->setFlash(__('削除したアカウント。新規アカウントを作ってください'));
							$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 削除したアカウントでログインした';
							$this->Log->writeLog('login.txt',$log);
							return $this->redirect(array('action'=>'login'));
						}
					}else{//Xu ly dang nhap cho manager
							$this->Session->setFlash(__('管理者は別のログイン画面があります。'));
							return $this->redirect(array('action'=>'login'));

					}
					
				}

				if($this->Auth->login()){
					$log="INFO, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', ログインした成功して登録した';
					$this->Log->writeLog('login.txt',$log);
					$this->Session->setFlash('ログインした');
					$this->User->id=$user['User']['id'];
					$this->User->saveField('failedNo',0);
					
					if($this->Auth->user('role')=='manager')
						return $this->redirect(array('controller'=>'manages','action'=>'index'));
					elseif($this->Auth->user('role')=='teacher')
						return $this->redirect(array('controller'=>'teachers','action'=>'index'));
					else
						return $this->redirect(array('controller'=>'students','action'=>'index'));
					}
				else{
					$this->Session->setFlash(__('ユーザ名又はパスワードが間違ってしまった'));
					$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 第'.($user['User']['failedNo']+1).'回：ユーザ名又はパスワードが間違ってしまった';
					$this->Log->writeLog('login.txt',$log);

					if($user['User']['role']!='manager'){
						if(($user['User']['failedNo']+1) == $max){
						$this->Session->setFlash(__('失敗したログインの回数は3回になってしまった。
						アカウントは一時にブロックされることになっている。あとで戻ってください。'));
						$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', 失敗したログインの回数は3回になってしまった。アカウントは一時にブロックされることになっている';
						$this->Log->writeLog('login.txt',$log);

						$this->User->id=$user['User']['id'];
						$this->User->saveField('state','blocked');
						$this->User->saveField('failedNo',0);
						}else{
							$this->User->id=$user['User']['id'];
							$failedNo=$user['User']['failedNo']+1;
							$this->User->saveField('failedNo', $failedNo);
						}
					}
					
				}
					

					
				}else{
					$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', アカウントが存在していない';
					$this->Log->writeLog('login.txt',$log);
					$this->Session->setFlash(__('アカウントは存在していない。新規アカウントを登録してください。'));
					}	
		}
	}

	public function verify1($id =null){
		$this->set('menu_type','empty');
		$user= $this->User->findById($id);
		$this->loadModel('Question');
		$questions = $this->Question->find('all');
		$vovans[0]='質問を選んでください';
		foreach ($questions as $question) {
			$vovans[$question['Question']['id']]=$question['Question']['content'];
		}
		$this->set('questions', $vovans);

		if($this->request->is('post')){
			$passwordHasher = new SimplePasswordHasher();

			if($user['User']['verify']==$passwordHasher->hash($this->request->data['User']['verify'])  && $user['User']['question']==$this->request->data['User']['question']){

				$this->Session->setFlash(__('確認するコードは正しい'));
				$this->User->id=$id;
				$this->User->saveField('state','normal');
				return $this->redirect(array('controller'=>'users','action'=>'login'));	
			}else{
				$this->Session->setFlash(__('確認するコードは間違ってしまった。'));
			}
		}
	}

	public function verify2($id =null, $IP =null){

		$this->set('menu_type','empty');
		$user= $this->User->findById($id);
		$this->loadModel('Question');
		$questions = $this->Question->find('all');
		$vovans[0]='質問を選んでください';
		foreach ($questions as $question) {
			$vovans[$question['Question']['id']]=$question['Question']['content'];
		}
		$this->set('questions', $vovans);

		if($this->request->is('post')){
			$user= $this->User->findById($id);
			$passwordHasher = new SimplePasswordHasher();
			if($user['User']['verify']==$passwordHasher->hash($this->request->data['User']['verify']) && $user['User']['question']==$this->request->data['User']['question']){

				$this->Session->setFlash(__('確認するコードは正しい'));
				$this->User->id = $id;
				$this->User->saveField('prevIP',$IP);
				return $this->redirect(array('controller'=>'users','action'=>'login'));
				
			}else{
				$this->Session->setFlash(__('確認するコードは間違ってしまった。'));
			}
		}
	}

	/**
	* function change teacher's password
	*
	* @author lucnd
	*/
	public function changePassword(){
		if($this->Auth->user('role')=='student')
			$this->set('menu_type','student_menu');
		elseif($this->Auth->user('role')=='teacher')
			$this->set('menu_type','teacher_menu');
		elseif($this->Auth->user('role')=='manager')
			$this->set('menu_type','manager_menu');
		
		$this->pageTitle = "パスワード変化";

		$userId = $this->Auth->user('id');
		$this->User->id = $userId;
		// current user
		$currUser = $this->User->findById($userId);
		// var_dump($currUser);die;

		if(!$this->User->exists()){
			throw new NotFoundException(__('ユーザが無効だ'));
		}

		if($this->request->is(array('post','put'))){
			// hash default sha1
			$passwordHasher = new SimplePasswordHasher();
			$arrPass = $this->request->data;
			// check current password
			if($passwordHasher->check($arrPass['User']['currPassword'],$currUser['User']['password'])){
				// check new password and confirm password
				if($arrPass['User']['newPassword'] == $arrPass['User']['confPassword']){
					// assign new password to password
					$currUser['User']['password'] = $arrPass['User']['newPassword'];
					// save user, run function beforeSave() to hash new password
					// $this->User->id = $userId;
					if($this->User->saveField('password',$arrPass['User']['newPassword'])){
						// write success log to log file 7: change_password.txt
						$log = '"SUCCESS", "'.(string)date('Y-m-d H:i:s').'", "'.(string)$userId.'"';
						$this->Log->writeLog('change_password.txt',$log);
						$this->Session->setFlash(__('パスワードが更新された'));
						if($this->Auth->user('role')=='manager')
							return $this->redirect(array('controller'=>'manages','action'=>'viewinfo'));
						elseif($this->Auth->user('role')=='teacher')
							return $this->redirect(array('controller'=>'teachers','action'=>'info'));
						else
							return $this->redirect(array('controller'=>'students','action'=>'viewInfo'));

					}
					else{
						$this->Session->setFlash(__('パスワードが変更されるのが失敗だ'));
						$log = '"FAIL", "'.(string)date('Y-m-d H:i:s').'", "'.(string)$userId.'", "パスワードが変更されるのが失敗だ"';
						$this->Log->writeLog('change_password.txt',$log);
					}					
				}
				else{
					$this->Session->setFlash(__('確認パスワードが間違い'));
					$log = '"FAIL", "'.(string)date('Y-m-d H:i:s').'", "'.(string)$userId.'", "確認パスワードが間違い"';
					$this->Log->writeLog('change_password.txt',$log);	
				}				
			}
			else{
				$this->Session->setFlash(__('現在パスワードが間違い'));
				$log = '"FAIL", "'.(string)date('Y-m-d H:i:s').'", "'.(string)$userId.'", "現在パスワードが間違い"';
				$this->Log->writeLog('change_password.txt',$log);	
			}			
		}else{
			$this->request->data = $this->User->read(null, $userId);
		}
	}

	public function role(){
		$this->set('menu_type','empty');
		// $this->layout='ajax';
		if($this->request->is('post')){
			if($this->request->data['User']['role']=="student")
				return $this->redirect(array('controller'=>'students','action'=>'register','student'));
			else
				return $this->redirect(array('controller'=>'teachers','action'=>'register','teacher'));	
		}
	}

	public function reset($id){
		$user= $this->User->findById($id);
		$password=$user['User']['first_password'];
		$sql = "UPDATE users SET password='$password' WHERE id='$id'";
		$this->User->query($sql);
		$this->Session->setFlash(__('初期パスワードにリセットした'));
		if($user['User']['role']=="student")
			return $this->redirect(array('controller'=>'manages','action'=>'index'));
		else if($user['User']['role']=="teacher")
			return $this->redirect(array('controller'=>'manages','action'=>'teacher'));
		
		
	}

	
	public function logout(){	
		//$this->Session->setFlash('またね！');
		//Xuan
		$this->Session->delete('monthxu');
		$this->Session->delete('yearxu');
		//Xuan
		$this->Auth->logout();
		$this->redirect(array('controller'=>'pages','action'=>'display','home'));	
		//return $this->redirect($this->Auth->logout());
	}

	public function lock($id=null){
		$user= $this->User->findById($id);
		$this->User->id =$id;
		if ($this->User->saveField('state','locked')) {
            $this->Session->setFlash(__('アカウントはロックされた'));
            if($user['User']['role']=="student")
				return $this->redirect(array('controller'=>'manages','action' => 'index')); 
			else if($user['User']['role']=="teacher")
				return $this->redirect(array('controller'=>'manages','action' => 'teacher')); 
		}
	}	

	public function unlock($id=null){
		$this->User->id =$id;
		if ($this->User->saveField('state','normal')) {
            $this->Session->setFlash(__('アカウントはアンロックした'));
			return $this->redirect(array('controller'=>'manages','action' => 'index')); 
		}
	}	

}

?>
