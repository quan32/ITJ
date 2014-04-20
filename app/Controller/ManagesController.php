<?php
App::uses('ConnectionManager', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
define ('BACKUP_FOLDER', realpath(dirname(__FILE__).DS.'..'.DS.'Backup'.DS));
define ('UPLOAD_FOLDER', realpath(dirname(__FILE__).DS.'..'.DS.'webroot'.DS.'uploads'));
class ManagesController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('info1', 'info2');

    if($this->Auth->isAuthorized()==false && !in_array($this->action, array('info1', 'info2'))){
      $this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
    }
	}

  public function backup(){
    $db_config = ConnectionManager::getDataSource('default')->config;
    //var_dump($db_config);die;
    $this->set('menu_type','manager_menu'); 
    if($this->request->is('post')){   
      //backup db
      date_default_timezone_set("Asia/Ho_Chi_Minh");
      $foldername= BACKUP_FOLDER.DS.date('Y_m_d__H_i_s');
      new Folder($foldername, true, 0777);
      $filename = $foldername.DS.'database.sql';
      $output = array();
      $sql = 'mysqldump -u'.$db_config['login'].' -p'.$db_config['password'].' '.$db_config['database'].' > "'.$filename.'"';
      exec($sql,$output);  

      //backup file
      $upload_folder = new Folder(UPLOAD_FOLDER);
      $upload_folder->copy($foldername.DS.'uploads');  
    }

    //display
    $backups = scandir(BACKUP_FOLDER);
    $this->set("backups",$backups);

  }

  public function restore($backup_time){
    $db_config = ConnectionManager::getDataSource('default')->config;
    //if($this->request->is('post')){

    //restore database
    $output = array();
    $foldername = BACKUP_FOLDER.DS.$backup_time;
    $filename= $foldername.DS.'database.sql';
    $sql = 'mysql -u'.$db_config['login'].' -p'.$db_config['password'].' '.$db_config['database'].' < "'.$filename.'"';
    exec($sql,$output);

    //restore file
    $backup_upload_folder = new Folder($foldername.DS.'uploads');
    $backup_upload_folder->copy(UPLOAD_FOLDER);

    return $this->redirect(array('action'=>'backup'));
  }

  public function delete_backup($backup_time){
    $foldername = new Folder(BACKUP_FOLDER.DS.$backup_time);
    $foldername->delete();
    return $this->redirect(array('action'=>'backup'));
  }
	public function isAuthorized($user){
		// Only manager can use these function
		if($user['role']=='manager')
			return true;
		return false;
	}

	public function info1(){
    $this->set('menu_type','empty');
		
	}
	public function info2(){
    $this->set('menu_type','empty');
		
	}

  public function resetVerifyCode($id){
    $this->loadModel('User');
    
    $this->User->id=$id;
    $user= $this->User->findById($id);
    $verify=$user['User']['first_verify'];
    $question=$user['User']['first_question'];

    $sql = "UPDATE users SET verify='$verify',question='$question' WHERE id='$id'";
    $this->User->query($sql);
    $this->Session->setFlash(__('初期VerifyCodeにリセットした'));
    return $this->redirect(array('controller'=>'manages','action'=>'teacher'));
  }


	public function index(){ // quan ly' User
     $this->set('menu_type','manager_menu');
	 $this->loadModel('Catagory');
				$catas = $this->Catagory->find('all');
				//debug($catas); die;
				$vovans[0]='全部';
				foreach ($catas as $cata) {
					$vovans[$cata['Catagory']['id']]=($cata['Catagory']['name']);
				}

				//debug($vovans); die;
				$this->set('catagory', $vovans);
		 $this->loadModel('User');
      if (!empty($this->request->data)) 
      {         
      if ($this->User->save($this->request->data)) {
      $this->Session->setFlash(__('アカウントは今から使用できる'));
      }
      } 
       
        $sql["conditions"] = array("role = 'student' AND state !='deleted' AND state !='rejected' AND state !='locked' ");
        $sql["limit"] = 6;
       
        $this->paginate = $sql;
        $data = $this->paginate('User');

        //$data = $this->User->find("all",$sql);
	       $this->set("users",$data);
         

	  }
  
  public function teacher(){ // quan ly' User
    $this->set('menu_type','manager_menu');

     $this->loadModel('User');
      if (!empty($this->request->data)) 
      {         
      if ($this->User->save($this->request->data)) {
      $this->Session->setFlash(__('アカウントは今から使用できる'));
      }
      } 
       
        $sql["conditions"] = array("role = 'teacher' AND state !='deleted' AND state !='rejected' AND state !='locked' ");
        $sql["limit"] = 6;
       
        $this->paginate = $sql;
        $data = $this->paginate('User');

        //$data = $this->User->find("all",$sql);
         $this->set("users",$data);
        // var_dump($data); die();
}
    
    public function manager(){ // quan ly' User
     $this->set('menu_type','manager_menu');
     $this->loadModel('User');
      if (!empty($this->request->data)) 
      {         
      if ($this->User->save($this->request->data)) {
      $this->Session->setFlash(__('アカウントは今から使用できる'));
      }
      } 
        $user_id = $this->Auth->user('id');
        $sql["conditions"] = array("role = 'manager' AND state !='deleted' AND state !='locked' AND id !=".$user_id);
       // var_dump($sql);die();
        $sql["limit"] = 6;
       
        $this->paginate = $sql;
        $data = $this->paginate('User');

        //$data = $this->User->find("all",$sql);
        $this->set("users",$data);
       
        // var_dump($data); die();

    }

  public function viewinfo(){
     $this->set('menu_type','manager_menu');
    $user_id = $this->Auth->user('id');
    $this->loadModel('User');
    $info = $this->User->findById($user_id);
    $this->set("info",$info);
    $this->set("user_id", $user_id);
  }
  public function detail($id){
   $this->set('menu_type','manager_menu');
   
    $user_id = $id;
    $this->loadModel('User');
    $info = $this->User->findById($user_id);
    $this->set("info",$info);
    $this->set("user_id", $user_id);
  }
   


  public function accept(){ // quan ly' User
  $this->set('menu_type','manager_menu');
     $this->loadModel('User');
      if (!empty($this->request->data)) 
      {         
      if ($this->User->save($this->request->data)) {
      
      if ($this->request->data["User"]["state"]=="normal") {
      $this->Session->setFlash(__('アカウントは今から使用できる'));
      }
      else
      $this->Session->setFlash(__('アカウントは断られた'));
        
      }
      } 
       
        $sql = array("conditions"=> array("state"=> "new"));
        $data = $this->User->find("all",$sql);
        $this->set("users",$data);
    // var_dump($data); die();

    }

    public function masterdata()
    {
      $this->set('menu_type','manager_menu');
      // debug($this->constants);die;
      $this->set("cons",$this->constants);
      //Configure::write('Session.timeout',40);
      //var_dump(Configure::read('Session.timeout'));die();
    }

    public function editdata($id)
      {
        $this->set('menu_type','manager_menu');
        $this->loadModel('Constant'); 
        $this->set("data",$this->Constant->findAllById($id));
        $this->Constant->id =$id;
        if(!$this->Constant->exists()){
          throw new NotFoundException(__('不当な定数'));
        }

        if ($this->request->is('post') || $this->request->is('put')) { 

          if ($this->Constant->save($this->request->data)) {

            //Su ly voi hang so thoi diem tu dong backup
            if($id==9){
              // $myFile = "./quan";
              // $myFile = "/var/spool/cron/crontabs/quan";
              // $fh = fopen($myFile, 'w') or die("can't open file");
              // $stringData = $this->request->data['Constant']['value']." sh /var/www/backup.sh";
              // fwrite($fh, $stringData);
              // fclose($fh);

              // $output = shell_exec('crontab -l');
              // echo $output;
              file_put_contents('/tmp/crontab.txt', "");
              $stringData = $this->request->data['Constant']['value']." sh /var/www/backup.sh";
              file_put_contents('/tmp/crontab.txt', $stringData.PHP_EOL);
              //$output = shell_exec('crontab -l');
              echo exec('crontab /tmp/crontab.txt');
              echo exec('/etc/init.d/cron restart');
              // die;

              // $result = shell_exec('/var/www/copy.sh');
              // //$result = shell_exec('sudo cp /var/www/ITJ/app/webroot/quan /var/spool/cron/crontabs/');
              // echo $result;
            }
            

              $this->Session->setFlash(__('定数は保存されていた'));
              return $this->redirect(array('action' => 'masterdata')); 
            }
                $this->Session->setFlash(
                    __('定数はまだ保存されていない。してみてください'));
        } else {
        //$this->request->data = $this->User->read(null, $id);
          //      unset($this->request->data['User']['password']);
            }

    }

  public function oder()
  {
    $this->set('menu_type','manager_menu');
     $users = array();
     $alls=null;
     $users_st = array();
     $alls_st=null;
     $log=null;
     $log1=null;
     $this->loadModel('Constant');
     $cost=$this->Constant->findByName("cost");
     $tmp=$this->Constant->findByName("rate");
     $rate=$tmp["Constant"]["value"]/100;


    if($this->request->is('post')) {
     $month=$this->request->data['Manage']['month'];
     $year=$this->request->data['Manage']['year'];
     $this->loadModel('Register');
     $this->loadModel('User');
    

     $sql_st = array("conditions"=> array('MONTH(Register.created)' => $month),
                   'group' => 'Register.user_id');
     
     $sql_st['fields']=array('Register.user_id','COUNT(Register.id) AS total');
     //debug($sql);
     $ok_st=$this->Register->find('all',$sql_st);
     $j=0;
     foreach ($ok_st as $all_st ) {
     //
     $x_st=$all_st[0]["total"]*$cost["Constant"]["value"];
     //var_dump($x); die();
     $ok_st[$j][0]["total"]=$x_st;
     $j++;
     }
     //var_dump($ok_st);die();
     $j=0;
    foreach ($ok_st as $all_st ) {
     $id_st=$all_st["Register"]["user_id"];
     $data_st=$this->User->findAllById($id_st);
     if($data_st !=null )
     {
      if($data_st[0]["User"]["state"] != "deleted") {
       $users_st[$id_st]=$data_st[0];
       $alls_st[$j]=$all_st;
       $j++;
      }
      
     }
   }
    // var_dump($alls_st);die();
    




     //sensei
     $sql = array("conditions"=> array('MONTH(Register.created)' => $month),
                   'group' => 'Lecture.user_id');
     
     $sql['fields']=array('Lecture.user_id','COUNT(Register.id) AS total');
     //debug($sql);
     $ok=$this->Register->find('all',$sql);
     $i=0;
     foreach ($ok as $all ) {
     //
     $x=$all[0]["total"]*$cost["Constant"]["value"]*$rate;
     //var_dump($x); die();
     $ok[$i][0]["total"]=$x;
     $i++;
     }

    //
     //var_dump($ok);
    
    $i=0;
    foreach ($ok as $all ) {
     $id=$all["Lecture"]["user_id"];
     $data=$this->User->findAllById($id);
     if($data !=null )
     {
      if($data[0]["User"]["state"] != "deleted") {
       $users[$id]=$data[0];
       $alls[$i]=$all;
       $i++;
      }
      
     }
    }

   // var_dump($alls); die();
     
   $admin_id=$this->Auth->user("id");
   $admin_name=$this->Auth->user("fullname"); 
  
   if ($this->request->data['Manage']['print']==true) {

   $file='ELS-UBT-'.$year.'-'.$month.'.tsv';
   $dir=new Folder('oder');
   $files=$dir->find($file);

   if (!empty($files)) 
   {
    $file_delete = new File($dir->pwd() . DS . $file);
    $file_delete->delete();
   }
   $log = 'ELS-UBT-GWK54M78,'.$year.','.$month.','.date('Y').','.date('m').','.date('d').','.date('H').','.date('i').','.date('s').','.$admin_id.','.$admin_name;  
   $log1=$log;
   $this->Log->writeOder($file,$log);
    
   foreach ($alls as $all ) {

   $id=$all["Lecture"]["user_id"];
   $log=$users[$id]["User"]["id"].','.$users[$id]["User"]["fullname"].','.$all[0]["total"].','.$users[$id]["User"]["address"].','.$users[$id]["User"]["mobile_No"].',54,'.$users[$id]["User"]["bank_acc"];
   $this->Log->writeOder($file,$log);
    
    }

    foreach ($alls_st as $all ) {

   $id=$all["Register"]["user_id"];
   $log=$users_st[$id]["User"]["id"].','.$users_st[$id]["User"]["fullname"].','.$all[0]["total"].','.$users_st[$id]["User"]["address"].','.$users_st[$id]["User"]["mobile_No"].',18,'.$users_st[$id]["User"]["credit_card_No"];
   $this->Log->writeOder($file,$log);
    
    }
   
   $log="END___END___END,".date('Y').','.date('m');
   $this->Log->writeOder($file,$log);
   

   
   $this->Session->setFlash(__('データはファイルに書き込んだ'));
   //return $this->redirect(array('action'=>'oder'));
   }
   else
   {
    $log1= 'ELS-UBT-GWK54M78,'.$year.','.$month.','.date('Y').','.date('m').','.date('d').','.date('H').','.date('i').','.date('s').','.$admin_id.','.$admin_name;  
    $log="END___END___END,".date('Y').','.date('m');
   }

    $this->set("month",$month);
    $this->set("year",$year);

     }
   $this->set("users",$users);
   $this->set("users_st",$users_st);
   $this->set("alls_st",$alls_st);
   $this->set("alls",$alls);
   $this->set("data",$log);
   $this->set("data1",$log1);
  }
  public function statistic(){
    $this->set('menu_type','manager_menu');
    $moneyThisMonth=0;
    if($this->request->is('post')) {
   //var_dump( $this->request->data['Manage']['month']);die;
      
      $this->loadModel('Register');
      $sql["conditions"] = array('MONTH(Register.created) = '.$this->request->data['Manage']['month']);
      $alls=$this->Register->find('all',$sql);
      
     
    
     $moneyTemp=0;
     $this->loadModel('Constant');
     $this->loadModel('User');
     $cost=$this->Constant->findByName("cost");
     $tmp=$this->Constant->findByName("rate");
     $rate=$tmp["Constant"]["value"]/100;
     foreach ($alls as $all) {
    //var_dump($all);
    
    $user=$this->User->findById($all['Lecture']['user_id']);
    if ($user["User"]["state"] != "deleted") {
    $moneyTemp = $moneyTemp +  $cost["Constant"]["value"];
    }
          
     }
    
    $moneyThisMonth = $moneyTemp * (1-$rate);
 
    }
   $this->set('moneyThisMonth',$moneyThisMonth);

  }

  public function register(){ //dang ki' admin mo'
  $this->set('menu_type','manager_menu');
     
    
    $this->loadModel('User');
    $this->loadModel('Ip');
    if($this->request->is('post')){
      // var_dump($this->Auth->user("id"));die;
      $this->request->data['User']['role']="manager";
      $this->request->data['User']['state']="normal";
      
      $data['Ip']['ip']=$this->request->data['User']['ip'];
     // var_dump($data);die();
       $this->User->create();
       $this->Ip->create();
		
      if($user=$this->User->save($this->request->data)){
		 $precode = $this->User->find('count', array(
        'conditions' => array('User.role' => 'manager')));
		//$precode = $precode+1;
      	if($precode<10) {
						$code = "M00".$precode;
					}else {
						if($precode) { $code = "M0".$precode;
							}else {$code = "M".$precode;}
						}
					$this->User->saveField('code',$code);
        $data['Ip']['user_id']=$user["User"]["id"];
        $this->Ip->save($data);
        $this->Session->setFlash(__('アカウントは保存されていた。'));
       return $this->redirect(array('action'=>'index'));
      }

      $this->Session->setFlash(__('アカウントは保存されていない。もう一度してみてください'));
    }
  }

  public function lecture(){ // Quan ly' bai giang
  $this->set('menu_type','manager_menu');

    $this->loadModel('Lecture');

    $options['joins'] = array(
    array('table' => 'users',
          'alias' => 'User1',
          'type' => 'LEFT',
          'conditions' => array('User1.id = Lecture.user_id')
    )
);
    $options['fields'] = array('User1.username','User1.state', 'Lecture.*');

   // $data=$this->Lecture->find('all', $options);
    $options['limit'] = 9;

    $this->paginate = $options;
    $data = $this->paginate('Lecture');
    // debug($data);die();
    $this->set("lectures",$data);
  }

  public function change(){ // doi pass va edit IP
    $this->set('menu_type','manager_menu');

    $this->loadModel('Ip');

     if($this->request->is('post')){
    //   var_dump( $this->Auth->user("id"));die;
      $this->request->data['Ip']['user_id']=$this->Auth->user("id");
      
      $this->Ip->create();
      if($this->Ip->save($this->request->data)){
        $this->Session->setFlash(__('IPアドレスは保存されていた'));
       return $this->redirect(array('action'=>'change'));
      }
    }


    $options['joins'] = array(
    array('table' => 'users',
          'alias' => 'User',
          'type' => 'LEFT',
          'conditions' => array(
            'User.id = Ip.user_id',
        )
    )
  );
    $options['fields'] = array('User.username', 'Ip.*');
    $options["conditions"] = array('user_id' =>$this->Auth->user("id"));
    
   // $sql = array("conditions"=> array('user_id' =>$this->Auth->user("id")));
    



    $data=$this->Ip->find('all',$options);
    //var_dump($data); die();
    $this->set("datas",$data);

  }
  public function adminip($id){ // doi pass va edit IP
    $this->set('menu_type','manager_menu');

    $this->loadModel('Ip');

     


    $options['joins'] = array(
    array('table' => 'users',
          'alias' => 'User',
          'type' => 'LEFT',
          'conditions' => array(
            'User.id = Ip.user_id',
        )
    )
  );
    $options['fields'] = array('User.username', 'Ip.*');
    $options["conditions"] = array('user_id' =>$id);
    
   // $sql = array("conditions"=> array('user_id' =>$this->Auth->user("id")));
    



    $data=$this->Ip->find('all',$options);
    //var_dump($data); die();
    $this->set("datas",$data);

  }

  public function deleteip($id)
  {
    $this->set('menu_type','manager_menu');
    $this->loadModel('Ip');  
    $this->Ip->id = $id;
    //$this->Source->deleteAll(array('lecture_id'=>$id));
    

    if(!$this->Ip->exists())
      throw new NotFoundException(__('不当なIPアドレス'));

    if($this->Ip->delete()){
      $this->Session->setFlash(__('IPアドレスは削除された'));
      return $this->redirect(array('action'=>'change'));
    }
    $this->Session->setFlash(__('IPアドレスは削除されていない'));
      return $this->redirect(array('action' => 'change'));
  }
  public function editip($id)
  {
    $this->set('menu_type','manager_menu');
    $this->loadModel('Ip'); 
    $this->Ip->id =$id;
    $this->set("current_user",$this->Auth->user("id"));
    if(!$this->Ip->exists()){
      throw new NotFoundException(__('不当なIPアドレス'));
    }
    

    if ($this->request->is('post') || $this->request->is('put')) { 
      if ($this->Ip->save($this->request->data)) {

          $this->Session->setFlash(__('IPアドレスは保存されていた'));
          $user=$this->Ip->findById($id);
          if($user["Ip"]["user_id"] == $this->Auth->user("id"))
          return $this->redirect(array('action' => 'change'));
          else
          return $this->redirect(array('action' => 'adminip',$user["Ip"]["user_id"]));
           
        }
            $this->Session->setFlash(
                __('IPアドレスはまだ保存されていない。してみてください'));
    } else {
    //$this->request->data = $this->User->read(null, $id);
      //      unset($this->request->data['User']['password']);
        }
         $this->request->data = $this->Ip->read(null, $id);

  }

  public function delete_lec($id =null){
    if ($this->request->is(array('post','get'))){
      $this->loadModel('Lecture');
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
        return $this->redirect(array('controller'=>'manages','action'=>'lecture'));
        // if($this->Auth->user('role')=='teacher')
        //  return $this->redirect(array('controller'=>'teachers','action'=>'index'));
        // else if($this->Auth->user('role')=='manager')
        //  return $this->redirect(array('controller'=>'manages','action'=>'lecture'));

      }
      $this->Session->setFlash(__('講義の削除するのは失敗した'));
        return $this->redirect(array('action' => 'lecture'));
    }else{
      $this->Session->setFlash(__('間違った操作'));
        return $this->redirect(array('controller'=>'manages','action' => 'lecture'));
    }
    
  }

  public function editinfo($id = null){
    $this->set('menu_type','manager_menu');
     $this->loadModel('User');

    if ($this->request->is('post') || $this->request->is('put')) { 
      $data = $this->request->data['User'] ;
      
      $user_id = $data['id'];
     
      $this->User->id =$user_id;

       if(!$this->User->exists()){
      throw new NotFoundException(__('不当なユーザ'));
       }

    $data['date_of_birth'] = $data['date_of_birth']['month'].'-'.$data['date_of_birth']['day'].'-'.$data['date_of_birth']['year'];

    
      if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('情報は更新されていた'));
         //    var_dump($this->request->data);die();
              

        //  return $this->redirect(array('action' => 'index')); 
                //var_dump($this->request->data); die();
                
                return $this->redirect(array('action' => 'detail',$user_id));
               
        }
        
            $this->Session->setFlash(
                __('エラーが起きてしまった。してみてください'));
    } else {
       $this->User->id =$id;

       if(!$this->User->exists()){
      throw new NotFoundException(__('不当なユーザ'));
       }
        $this->request->data = $this->User->read(null, $id);
         // unset($this->request->data['User']['mobile_No']);
        }
  }

  




}
?>