<?php
class Lecture extends AppModel {
	var $name='Lecture';
	public $belongsTo = array('User');
	public $hasMany = array('Source','Comment', 'Test', 'Favorite', 'Register');

	public $validate = array(
		'name' => array(
			'rule' => array('minLength', 10),
			'required' => true,
			'message' => '10桁～の講義名を入力してください'),
		'description' => array(
            'between' => array(
                'rule'    => array('between', 30, 225),
                'message' => '30～225桁の紹介する情報を入力してください'
            ))
	);
	
}