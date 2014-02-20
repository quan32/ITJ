<?php
class Thread extends AppModel{
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'You have to enter title'
			)
		);

	public function isOwnedBy($post, $user){
		return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
	}
	}

?>