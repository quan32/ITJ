<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class User extends AppModel{
	public $hasMany = array('Lecture','Ip','Result','Test','Register');

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
			),
		'currPassword' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'message' => 'Current password is not empty'
				),
			),
		'newPassword' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'message' => 'New password must not empty'
				),
			),
		'confPassword' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'message' => 'Confirm password must not empty'
				),
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