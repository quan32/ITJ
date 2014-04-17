<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class User extends AppModel{
	public $hasMany = array('Lecture','Ip','Result','Register');

	public $validate = array(

		'username' => array(
            'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                // 'required' => true,
                'message'  => '文字又は数字を入力してください'
            ),
            'between' => array(
                'rule'    => array('between', 8, 30),
                'message' => '8～30桁のユーザ名を入力してください'
            )
        ),

		'password'=> array(
			'rule' => array('minLength', 8),
			// 'required' => true,
			'message' => '最低の長さは8桁'),

		'fullname' => array(
        	'rule' => array('minLength', 3),
			// 'required' => true,
			'message' => '最低の長さは3桁'),	

		'mobile_No' => array(
        	 'alphaNumeric' => array(
                'rule'     => 'numeric',
                // 'required' => true,
                'message'  => '数字を入力してください'),
            'between' => array(
                'rule'    => array('between', 10, 15),
                'message' => '10～15桁の電話番号を入力してください')),

		'mail' => array(
			'rule'=>'email',
			'message'=>'メールフォーマットで入力してください'),

		'currpassword' => array(
			'rule' => array('minLength', 8),
			// 'required' => true,
			'message' => '現在パスワードを入力してください'),

		'newpassword' => array(
			'rule' => array('minLength', 8),
			// 'required' => true,
			'message' => '８桁以上の新パスワードを入力してください'),

		'confpassword' => array(
			'rule' => array('minLength', 8),
			// 'required' => true,
			'message' => '確認するパスワードを入力してください'),
		'currVerify' => array(
			'rule' => array('minLength', 8),
			// 'required' => true,
			'message' => '現在確認するコードを入力してください'),

		'newVerify' => array(
			'rule' => array('minLength', 8),
			// 'required' => true,
			'message' => '８桁以上の新確認するコードを入力してください'),

		'confVerify' => array(
			'rule' => array('minLength', 8),
			// 'required' => true,
			'message' => 'もう一度確認するコードを入力してください'),

		'address' => array(
			'rule' => 'notEmpty',
			// 'require' => true,
			'message' => '住所を入力してください'),

		'bank_acc' => array(
			'rule' => 'notEmpty',
			// 'required' => true,
			'message' => '銀行口座を入力してください'),

		'credit_card_No' => array(
			'rule' => 'notEmpty',
			'message' => 'クレジットカードを入力してください'),

		'verify' => array(
			'rule' => 'alphaNumeric',
			// 'required' => true,
			'message'  => '確認するコードを入力してください')					
		);


	public function beforeSave($options = array()){

		$passwordHasher = new SimplePasswordHasher();

		if(isset($this->data[$this->alias]['password'])){
			$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
			$this->data[$this->alias]['first_password']=$this->data[$this->alias]['password'];
		}

		if(isset($this->data[$this->alias]['verify'])){
			$this->data[$this->alias]['verify'] = $passwordHasher->hash($this->data[$this->alias]['verify']);
			$this->data[$this->alias]['first_verify']=$this->data[$this->alias]['verify'];
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