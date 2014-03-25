<?php
class ManagesController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('info1', 'info2');

    if($this->Auth->isAuthorized()==false && !in_array($this->action, array('info1', 'info2'))){
      $this->redirect(array('controller'=>'pages','action'=>'display', 'error'));
    }
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

	public function index(){ // quan ly' User
    $this->set('menu_type','manager_menu');
		 $this->loadModel('User');
      if (!empty($this->request->data)) 
      {         
      if ($this->User->save($this->request->data)) {
      $this->Session->setFlash(__('アカウントは今から使用できる'));
      }
      } 
       
        $sql = array("conditions"=> array("role != 'manager' "));
        $data = $this->User->find("all",$sql);
		    $this->set("users",$data);
        // var_dump($data); die();

	  }


  public function accept(){ // quan ly' User
  $this->set('menu_type','manager_menu');
     $this->loadModel('User');
      if (!empty($this->request->data)) 
      {         
      if ($this->User->save($this->request->data)) {
      $this->Session->setFlash(__('アカウントは今から使用できる'));
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

              $this->Session->setFlash(__('IPアドレスは保存されていた'));
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

    if($this->request->is('post')) {
     $month=$this->request->data['Manage']['month'];
     $year=$this->request->data['Manage']['year'];
     $this->loadModel('Register');
     $this->loadModel('User');
   
     $sql = array("conditions"=> array('MONTH(Register.created)' => $month),
                   'group' => 'Lecture.user_id');
     
     $sql['fields']=array('Lecture.user_id','COUNT(Lecture.cost) AS total');
     //debug($sql);
     $alls=$this->Register->find('all',$sql);
      
     //debug($alls);
    foreach ($alls as $all ) {
     $id=$all["Lecture"]["user_id"];
     $data=$this->User->findAllById($id);
     $users[$id]=$data[0];
    }
     
 
   if ($this->request->data['Manage']['print']==true) {

 
   $admin_id=$this->Auth->user("id");
   $admin_name=$this->Auth->user("fullname"); 
   

   $file='ELS-UBT-'.$year.'-'.$month.'.tsv';
   $dir=new Folder('oder');
   $files=$dir->find($file);

   if (empty($files)) {
   $log = 'ELS-UBT-GWK54M78,'.$year.','.$month.','.date('Y').','.date('m').','.date('d').','.date('H').','.date('i').','.date('s').','.$admin_id.','.$admin_name;  
   $this->Log->writeOder($file,$log);
    
   foreach ($alls as $all ) {

   $id=$all["Lecture"]["user_id"];
   $log=$users[$id]["User"]["id"].','.$users[$id]["User"]["username"].','.$all[0]["total"].','.$users[$id]["User"]["address"].','.$users[$id]["User"]["mobile_No"].','.$users[$id]["User"]["credit_card_No"].','.$users[$id]["User"]["bank_acc"];
   $this->Log->writeOder($file,$log);
    
    }
   
   $log="END___END___END";
   $this->Log->writeOder($file,$log);
   }

   
   $this->Session->setFlash(__('データはファイルに書き込んだ'));
   return $this->redirect(array('action'=>'oder'));
   }
   

    $this->set("month",$month);
    $this->set("year",$year);

     }
   $this->set("users",$users);
   $this->set("alls",$alls);

  }
  public function statistic(){
    $this->set('menu_type','manager_menu');
    $moneyThisMonth=0;
    if($this->request->is('post')) {
   //var_dump( $this->request->data['Manage']['month']);die;
      
      $this->loadModel('Register');
      $sql = array("conditions"=> array('MONTH(Register.created)' =>$this->request->data['Manage']['month']));
      $alls=$this->Register->find('all',$sql);
      
     
    
      $moneyTemp=0;
     foreach ($alls as $all) {
    //var_dump($all['Lecture']['cost']);die();

      
    $moneyTemp = $moneyTemp +  $all['Lecture']['cost'];
          
     }

    $moneyThisMonth = $moneyTemp * 0.4;
 
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

    $data=$this->Lecture->find('all', $options);

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
    if(!$this->Ip->exists()){
      throw new NotFoundException(__('不当なIPアドレス'));
    }

    if ($this->request->is('post') || $this->request->is('put')) { 
      if ($this->Ip->save($this->request->data)) {

          $this->Session->setFlash(__('IPアドレスは保存されていた'));
          return $this->redirect(array('action' => 'change')); 
        }
            $this->Session->setFlash(
                __('IPアドレスはまだ保存されていない。してみてください'));
    } else {
    //$this->request->data = $this->User->read(null, $id);
      //      unset($this->request->data['User']['password']);
        }

  }
}
?>