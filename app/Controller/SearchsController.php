<?php
	class SearchsController extends  AppController{
		var $name = "Searchs";
		var $helpers = array('Form','Paginator','Html','Javascript','Common');
		var $components = array('Session','RequestHandler','Common');
		var $paginate = array();
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow('index', 'search', 'result');
		}
		function index()
		{
			$fullname = $this->request->data["q"];
			//var_dump($fullname);
       		 $data = $this->Search->find('all',array(
			 'fields'=>array('User.id','User.fullname','Search.name','Search.cost','Search.description'),
			 'conditions'=>array('OR'=>array(
											array('User.fullname LIKE'=>"%$fullname%"),
											array('Search.name LIKE'=>"%$fullname%"),
											array('Search.description LIKE'=>"%$fullname%")
								))));
		if(count($data)>0)
		{
			//debug($data);
			$this->set('lectureinfo',$data);
			}else {
				//echo "<h2>No Result</h2>";
				$this->set('lectureinfo',NULL);
				}
		}
		function search() {
			// the page we will redirect to
			echo "search";
			$url['action'] = 'result';
			foreach ($this->data as $k=>$v){ 
				foreach ($v as $kk=>$vv){ 
					$url[$k.'.'.$kk]=$vv; 
				} 
			}
			// redirect the user to the url
			$this->redirect($url, null, true);
		}

		  function result(){
		  echo "result";
			/*$conditions = array();
			$data = array();
			if(!empty($this->passedArgs)){
				//Fillter fullname
				if(isset($this->passedArgs['User.fullname'])) {
					$fullname = $this->passedArgs['User.fullname'];
					//$conditions[] =array();
					$conditions[] = array(
					'User.fullname LIKE' => "%$fullname%"
					);
					$data['User']['fullname'] = $fullname;
				}
				//Limit and Order By
				$this->paginate= array(
					'limit' => 4,
					'order' => array('fullname' => 'desc'),
				);
				
				$this->data = $data;
				$this->set("posts",$this->paginate("User",$conditions));
			}*/
		}
	} 
?>