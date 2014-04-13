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
			
		} else { $this->set('view_regis',0);}
        $this->set('teacher_id',$this->Auth->user('id'));
        $conditions = array();
        $data = array();
        if(!empty($this->passedArgs)){
            if(isset($this->passedArgs['Search.keyword'])) {
    			$keywords = $this->passedArgs['Search.keyword'];
				$catagory = $this->passedArgs['Search.catagory'];
				if($catagory == "0")
				{
					$conditions[] = array(
						"OR" => array(
									'Search.name LIKE' => "%$keywords%",
									'Search.description LIKE' => "%$keywords%",
									'User.fullname LIKE' => "%$keywords%" 
								)
					);
				}else
				{
					$conditions[] = array (
						"AND" => array('Search.category_id' => "$catagory",
										"OR" => array(
												'Search.name LIKE' => "%$keywords%",
												'Search.description LIKE' => "%$keywords%",
												'User.fullname LIKE' => "%$keywords%"))
					);
					}
					//echo $conditions;
                $data['Search']['description'] = $keywords; 
            }
            //Limit and Order By
            $this->paginate= array(
                'limit' => 5,
                'order' => array('id' => 'asc'),
            );
            
            $this->data = $data;
            $this->set("posts",$this->paginate("Search",$conditions));
        }
    }
}