<?php
class Lecture extends AppModel {
	var $name='Lecture';
	
	public $hasMany = array('Source');
	public $belongsTo = array('User');

	//Kiem tra dau vao
	
}