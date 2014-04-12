<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('CakeTime', 'Utility');
class UsersController extends AppController{

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('login', 'role', 'verify1','verify2');
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
		// if($this->request->is('post')){
			// debug($id);die;

			$this->User->id = $id;
			if(!$this->User->exists())
				throw new NotFoundException(__('このアカウントは存在していない'));

			if($this->User->saveField('state','deleted')){
				$this->Session->setFlash(__('アカウントは削除した'));
				if($this->Auth->user('role')!='manager')
					return $this->redirect($this->Auth->logout());
				return $this->redirect(array('controller'=>'manages','action'=>'index'));
			}
			$this->Session->setFlash(__('アカウントはまだ削除されていなかった'));
				if($this->Auth->user('role')=='teacher')
					return $this->redirect(array('controller'=>'teachers','action'=>'index'));
				elseif($this->Auth->user('role')=='student')
					return $this->redirect(array('controller'=>'students','action'=>'index'));
				elseif($this->Auth->user('role')=='manager')
					return $this->redirect(array('controller'=>'manages','action'=>'index'));

			// }
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

					if($user['User']['failedNo'] == $max){
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
					

					
				}else{
					$log="ERROR, ".date('Y-m-d H:i:s').', '.$this->request->data['User']['username'].', アカウントが存在していない';
					$this->Log->writeLog('login.txt',$log);
					$this->Session->setFlash(__('アカウントは存在していない。新規アカウントを登録してください。'));
					}	
		}
	}

	public function verify1($id =null){
		$this->set('menu_type','empty');
		if($this->request->is('post')){
			$user= $this->User->findById($id);
			$passwordHasher = new SimplePasswordHasher();
			if($user['User']['verify']==$passwordHasher->hash($this->request->data['User']['verify'])){

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
		if($this->request->is('post')){
			$user= $this->User->findById($id);
			$passwordHasher = new SimplePasswordHasher();
			if($user['User']['verify']==$passwordHasher->hash($this->request->data['User']['verify'])){

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
							return $this->redirect(array('controller'=>'manages','action'=>'info'));
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
		return $this->redirect(array('controller'=>'manages','action'=>'index'));
		
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
		$this->User->id =$id;
		if ($this->User->saveField('state','locked')) {
            $this->Session->setFlash(__('アカウントはロックされた'));
			return $this->redirect(array('controller'=>'manages','action' => 'index')); 
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
