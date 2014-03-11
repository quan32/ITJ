<?php
class Lecture extends AppModel {
	var $name='Lecture';
	public $belongsTo = array('User');
	public $hasMany = array('Source','Comment', 'Test', 'Favorite', 'Register');

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => '講義名を入力してください'),
		'description' => array(
			'rule' => array('maxLength', 255), 
        	'message' => '入力したデータの長さは２５５桁以上だ'
		)
	);
	
}