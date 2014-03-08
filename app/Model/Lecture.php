<?php
class Lecture extends AppModel {
	var $name='Lecture';
	public $belongsTo = array('User');
	public $hasMany = array('Source','Comment', 'Test', 'Favorite');
	
}