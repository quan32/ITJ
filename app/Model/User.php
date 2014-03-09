<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class User extends AppModel{
	public $hasMany = array('Lecture','Ip','Result','Register');

	public $validate = array(

		'username' => array(
            'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'required' => true,
                'message'  => '文字又は数字を入力してください'
            ),
            'between' => array(
                'rule'    => array('between', 3, 30),
                'message' => '3～30桁のユーザ名を入力してください'
            )
        ),

		'password'=> array(
			'rule' => array('minLength', 8),
			'required' => true,
			'message' => '最低の長さは8桁'),

		'fullname' => array(
        	'rule' => 'notEmpty',
			'required' => true,
			'message' => '空きフィールドをしないでください'),	

		'mobile_No' => array(
        	'rule' => 'numeric',
        	'message' => '数字を入力してください'),

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

		'address' => array(
			'rule' => 'notEmpty',
			'require' => true,
			'message' => '住所を入力してください'),

		'bank_acc' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => '銀行口座を入力してください'),

		'credit_card_No' => array(
			'rule' => 'notEmpty',
			'message' => 'クレジットカードを入力してください'),

		'verify' => array(
			'rule' => 'alphaNumeric',
			'required' => true,
			'message'  => '確認するコードを入力してください')					
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