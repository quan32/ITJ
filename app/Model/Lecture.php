<?php
class Lecture extends AppModel {
	var $name='Lecture';
	public $belongsTo = array('User');
	public $hasMany = array('Source','Comment', 'Test', 'Favorite', 'Register');

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Please enter name for lecture.'),
		'cost' => array(
			'rule' => array('numeric'),
			'required' => true,
			'message' => 'Please enter cost for lecture.'),
		'description' => array(
			'rule' => array('maxLength', 255), 
        	'message' => 'Description over max of length (255 character).'
		)
	);
	
}