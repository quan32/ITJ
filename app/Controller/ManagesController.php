<?php
class ManagesController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('info1', 'info2');
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
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
      $this->Session->setFlash(__('The user has been accepted'));
      }
      } 
       
       // $sql = array("conditions"=> array("state"=> "new"));
        $data = $this->User->find("all");
		    $this->set("users",$data);
    // var_dump($data); die();

	  }


  public function accept(){ // quan ly' User
  $this->set('menu_type','manager_menu');
     $this->loadModel('User');
      if (!empty($this->request->data)) 
      {         
      if ($this->User->save($this->request->data)) {
      $this->Session->setFlash(__('The user has been accepted'));
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
          throw new NotFoundException(__('Invalid constant'));
        }

        if ($this->request->is('post') || $this->request->is('put')) { 
          if ($this->Constant->save($this->request->data)) {

              $this->Session->setFlash(__('The ip has been saved'));
              return $this->redirect(array('action' => 'masterdata')); 
            }
                $this->Session->setFlash(
                    __('The constant could not be saved. Please, try again.'));
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

   
   $this->Session->setFlash(__('The oder has been printed'));
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
    if($this->request->is('post')){
      // var_dump($this->request->data);die;
      $this->request->data['User']['role']="manager";
      $this->request->data['User']['state']="normal";
      $this->User->create();
      if($this->User->save($this->request->data)){
        $this->Session->setFlash(__('The user has been saved'));
       return $this->redirect(array('action'=>'index'));
      }

      $this->Session->setFlash(__('The user could no be saved. Please try again'));
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
        $this->Session->setFlash(__('The Ip has been saved'));
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
      throw new NotFoundException(__('Invalid Ip'));

    if($this->Ip->delete()){
      $this->Session->setFlash(__('Ip deleted'));
      return $this->redirect(array('action'=>'change'));
    }
    $this->Session->setFlash(__('Ip was not deleted'));
      return $this->redirect(array('action' => 'change'));
  }
  public function editip($id)
  {
    $this->set('menu_type','manager_menu');
    $this->loadModel('Ip'); 
    $this->Ip->id =$id;
    if(!$this->Ip->exists()){
      throw new NotFoundException(__('Invalid ip'));
    }

    if ($this->request->is('post') || $this->request->is('put')) { 
      if ($this->Ip->save($this->request->data)) {

          $this->Session->setFlash(__('The ip has been saved'));
          return $this->redirect(array('action' => 'change')); 
        }
            $this->Session->setFlash(
                __('The ip could not be saved. Please, try again.'));
    } else {
    //$this->request->data = $this->User->read(null, $id);
      //      unset($this->request->data['User']['password']);
        }

  }
}
?>