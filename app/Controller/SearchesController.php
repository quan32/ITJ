<?php
class SearchesController extends  AppController{
    var $paginate = array();

		public function beforeFilter(){
		parent::beforeFilter();
		// $this->Auth->allow('search', 'result');
	}

	public function isAuthorized($user){
		// Only teacher can use teacher's function
		if($user['role']=='student' || $user['role']=='teacher' || $user['role']=='manager')
			return true;
		return false;
	}
    /**
     * Searching and Paging 
     * Url = http://mrphp.com.au/code/search-forms-cakephp
     * Complex Find Conditions : http://book.cakephp.org/view/1030/Complex-Find-Conditions
     */ 
    //Search 
    function search() {
    	$this->set('menu_type','menu');
		// the page we will redirect to
		$url['action'] = 'result';
		// build a URL will all the search elements in it
		// the resulting URL will be 
		// example.com/cake/posts/index/Search.keywords:mykeyword/Search.tag_id:3
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
    	if($this->Auth->user('role')=='student')
            $this->set('menu_type','student_menu');
        elseif($this->Auth->user('role')=='teacher')
            $this->set('menu_type','teacher_menu');
        
        $conditions = array();
        $data = array();
        if(!empty($this->passedArgs)){
            if(isset($this->passedArgs['Search.keyword'])) {
    			$keywords = $this->passedArgs['Search.keyword'];
    			$conditions[] = array(
                    "OR" => array(
								'Search.name LIKE' => "%$keywords%",
                                'Search.description LIKE' => "%$keywords%",
                                'User.fullname LIKE' => "%$keywords%" 
                            )
    			);
                $data['Search']['description'] = $keywords; 
            }
            //Limit and Order By
            $this->paginate= array(
                'limit' => 8,
                'order' => array('id' => 'asc'),
            );
            
            $this->data = $data;
            $this->set("posts",$this->paginate("Search",$conditions));
        }
    }
}