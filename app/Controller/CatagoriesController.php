<?php
class CatagoriesController extends AppController{

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
	public function create() {
		if($this->Auth->user('role')=='student') {
            $this->set('menu_type','student_menu');}
        elseif($this->Auth->user('role')=='teacher'){
            $this->set('menu_type','teacher_menu');
		} else { 
			$this->set('menu_type','manager_menu');}
		if($this->request->is('post')){
			if($this->checkExits($this->request->data['Catagory']['name']) !=1) {
				$data = array(
						'Catagory' =>array(	
								'name' => $this->request->data['Catagory']['name'])
						);
					$this->loadModel('Catagory');
					$this->Catagory->create();
					if($this->Catagory->save($data)) {
						$this->Session->setFlash(__('データベースに保存しました。'));
						return $this->redirect(array('controller'=>'lectures','action'=>'add'));
						}else {
							$this->Session->setFlash(__('エラーがあります。操作が完成しない'));
							return $this->redirect(array('controller'=>'lectures','action'=>'add'));
							
							}
				}else {
					$this->Session->setFlash(__('この名前はシステムにありました。他の名前を選択してください'));
					}
			
			}
		}
	public function checkExits($name = null){
		$this->loadModel('Catagory');
			$catas = $this->Catagory->find('all');
				//debug($catas); die;
				//$vovans[0]='カテゴリを選んでください';
				foreach ($catas as $cata) {
					if($name == $cata['Catagory']['name']) return 1;
				}
				return 0;
		}
		
}