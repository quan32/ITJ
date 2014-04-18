<?php
class Lecture extends AppModel {
	var $name='Lecture';
	public $belongsTo = array('User');
	public $hasMany = array('Source','Comment', 'Test', 'Favorite', 'Register');

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'message' => '空きフィールドはだめ！'),
		'description' => array(
            'rule' => 'notEmpty',
			'message' => '空きフィールドはだめ！')
		
	);
	
}