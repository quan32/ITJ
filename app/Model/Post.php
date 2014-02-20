<?php
class Post extends AppModel{
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'You have to enter title'
			),
		'body' => array(
			'rule' => 'notEmpty',
			'message' => 'You have to enter body'
			),
		
		);

	public function isOwnedBy($post, $user){
		return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
	}
	}

?>