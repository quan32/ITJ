<?php
class SearchesController extends  AppController{
    var $paginate = array();

		public function beforeFilter(){
		parent::beforeFilter();
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='student' || $user['role']=='teacher' || $user['role']=='manager')
			return true;
		return false;
	}
    //Search 
    function search() {
    	$this->set('menu_type','menu');
		// the page we will redirect to
		$url['action'] = 'result';
		foreach ($this->data as $k=>$v){ 
			foreach ($v as $kk=>$vv){ 
				$url[$k.'.'.$kk]=$vv; 
			} 
		}
		// redirect the user to the url
		$this->redirect($url, null, true);
	}
    
    //resutl
    function result(){
    	if($this->Auth->user('role')=='student') {
			$this->set('view_regis',1);
            $this->set('menu_type','student_menu');}
        elseif($this->Auth->user('role')=='teacher'){
            $this->set('menu_type','teacher_menu');
			$this->set('view_regis',2);
			
		} else { 
			$this->set('view_regis',0);
			$this->set('menu_type','manager_menu');
				}
		$this->loadModel('Catagory');
				$catas = $this->Catagory->find('all');
				//debug($catas); die;
				$vovans[0]='全部';
				foreach ($catas as $cata) {
					$vovans[$cata['Catagory']['id']]=($cata['Catagory']['name']);
				}

				//debug($vovans); die;
				$this->set('catagory', $vovans);
        $this->set('teacher_id',$this->Auth->user('id'));
        $conditions = array();
		$this->loadModel('User');
        $data = array();
        $con_type = 0;
        if(!empty($this->passedArgs)){
            if(isset($this->passedArgs['Search.keyword'])) {
    			$keywords = $this->passedArgs['Search.keyword'];
    			if(strpos($keywords,'+')){
	    			if($keywords!=''){
	    				$kw = explode('+',$keywords);
	    				$con_type = 1;

	    			}
	    		}
	    		else if(strpos($keywords,'-')){

	    			if($keywords!=''){
	    				$kw = explode('-',$keywords);
	    				$con_type = 2;
	    			}

}
    			else
    				$kw = array($keywords,'');
    			//var_dump($kw);die;
    			if(count($kw)<2) $kw[1] ='';
				$catagory = $this->passedArgs['Search.catagory'];
				$keywords2 = '';

				if($this->Auth->user('role')!='manager') {
					if($catagory == "0")
					{
						if($con_type!=2)
							$conditions[] = array(
								"AND" => array( 'Search.reported'=> "0",
												'User.state' => "normal",
													array("OR" => array(
																'Search.name LIKE' => "%$kw[0]%",
																'Search.description LIKE' => "%$kw[0]%",
																'User.fullname LIKE' => "%$kw[0]%" )),
													array("OR" => array(
																'Search.name LIKE' => "%$kw[1]%",
																'Search.description LIKE' => "%$kw[1]%",
																'User.fullname LIKE' => "%$kw[1]%" )))
							);
						else
							$conditions[] = array(
								"AND" => array( 'Search.reported'=> "0",
												'User.state' => "normal",
													"OR"=>array(array("OR" => array(
																'Search.name LIKE' => "%$kw[0]%",
																'Search.description LIKE' => "%$kw[0]%",
																'User.fullname LIKE' => "%$kw[0]%" )),
													array("OR" => array(
																'Search.name LIKE' => "%$kw[1]%",
																'Search.description LIKE' => "%$kw[1]%",
																'User.fullname LIKE' => "%$kw[1]%" ))))
							);
					}else
					{

						if($con_type!=2)
							$conditions[] = array(
								"AND" => array( 'Search.reported'=> "0",
												'Search.category_id' => "$catagory",
												'User.state' => "normal",
													array("OR" => array(
																'Search.name LIKE' => "%$kw[0]%",
																'Search.description LIKE' => "%$kw[0]%",
																'User.fullname LIKE' => "%$kw[0]%" )),
													array("OR" => array(
																'Search.name LIKE' => "%$kw[1]%",
																'Search.description LIKE' => "%$kw[1]%",
																'User.fullname LIKE' => "%$kw[1]%" )))
							);
						else
							$conditions[] = array(
								"AND" => array( 'Search.category_id' => "$catagory",
												'Search.reported'=> "0",
												'User.state' => "normal",
													"OR"=>array(array("OR" => array(
																'Search.name LIKE' => "%$kw[0]%",
																'Search.description LIKE' => "%$kw[0]%",
																'User.fullname LIKE' => "%$kw[0]%" )),
													array("OR" => array(
																'Search.name LIKE' => "%$kw[1]%",
																'Search.description LIKE' => "%$kw[1]%",
																'User.fullname LIKE' => "%$kw[1]%" ))))
							);
						
						}
				}else {
					if($catagory == "0")
					{
						$conditions[] = array(
							"AND" => array( 'User.state' => "normal",
												array("OR" => array(
															'Search.name LIKE' => "%$kw[0]%",
															'Search.description LIKE' => "%$kw[0]%",
															'User.fullname LIKE' => "%$kw[0]%" )),
												array("OR" => array(
															'Search.name LIKE' => "%$kw[1]%",
															'Search.description LIKE' => "%$kw[1]%",
															'User.fullname LIKE' => "%$kw[1]%" )))
						);
					}else
					{
						$conditions[] = array (
							"AND" => array('Search.category_id' => "$catagory",
												array("OR" => array(
															'Search.name LIKE' => "%$kw[0]%",
															'Search.description LIKE' => "%$kw[0]%",
															'User.fullname LIKE' => "%$kw[0]%" )),
												array("OR" => array(
															'Search.name LIKE' => "%$kw[1]%",
															'Search.description LIKE' => "%$kw[1]%",
															'User.fullname LIKE' => "%$kw[1]%" )))
						);
						}
					}
					//echo $conditions;
                $data['Search']['description'] = $keywords; 
            }
			$this->loadModel('Constant');
			$constantCost = $this->Constant->findByName('paging');
			$paging = $constantCost['Constant']['value'];
            //Limit and Order By
            $this->paginate= array(
                'limit' => $paging,
                'order' => array('id' => 'asc'),
            );
            
            $this->data = $data;
			//if($keywords!= '') {
			$this->set('key',$keywords);
			//}
            $this->set("posts",$this->paginate("Search",$conditions));
        }
    }
}