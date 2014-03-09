<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class User extends AppModel{
	public $hasMany = array('Lecture','Ip','Result','Register');

	public $validate = array(

		'username' => array(
            'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'required' => true,
                'message'  => 'Alphabets and numbers only'
            ),
            'between' => array(
                'rule'    => array('between', 3, 30),
                'message' => 'Between 3 to 30 characters'
            )
        ),

		'password'=> array(
			'rule' => array('minLength', 8),
			'required' => true,
			'message' => 'Minimum 8 characters long'),

		'fullname' => array(
        	'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Please enter fullname.'),	

		'mobile_No' => array(
        	'rule' => 'numeric',
        	'message' => 'Please enter the number of seconds.'),

		'mail' => 'email',
		'currpassword' => array(
			'rule' => array('minLength', 8),
			// 'required' => true,
			'message' => 'Please enter your current password'),

		'newpassword' => array(
			'rule' => array('minLength', 8),
			// 'required' => true,
			'message' => 'Please enter new password from 8 character.'),

		'confpassword' => array(
			'rule' => array('minLength', 8),
			// 'required' => true,
			'message' => 'Please confirm new password.'),

		'address' => array(
			'rule' => 'notEmpty',
			'require' => true,
			'message' => 'Please enter your address.'),

		'bank_acc' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Please enter your back account number.'),

		'credit_card_No' => array(
			'rule' => 'notEmpty',
			'message' => 'Please enter your credit card number.'),

		'verify' => array(
			'rule' => 'alphaNumeric',
			'required' => true,
			'message'  => 'Alphabets and numbers only')					
		);


	public function beforeSave($options = array()){
		if(isset($this->data[$this->alias]['password'])){
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']);
		}
		return true;
	}
	public function username($id){
		$tmp = $this->read(null, $id);
		if(empty($tmp)) return "匿名";
		$user = $tmp['User'];
		return $user['fullname']!='' ? $user['fullname'] : $user['username'];
	}
}

?>