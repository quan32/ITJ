<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class User extends AppModel{
	public $hasMany = array(
		'Lecture' => array(
			'className' => 'Lecture'
			)
		);

	public $validate = array(
		'username' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'A username is required'
				)
			),

		'password' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'A password is required'
				)
			)

		);

	public function beforeSave($options = array()){
		if(isset($this->data[$this->alias]['password'])){
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']);
		}
		return true;
	}
}

?>