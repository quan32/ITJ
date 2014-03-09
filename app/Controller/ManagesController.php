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
    $this->set('menu_type','menu');
		
	}
	public function info2(){
    $this->set('menu_type','menu');
		
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