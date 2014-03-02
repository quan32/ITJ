<?php
class Lecture extends AppModel {
	public $hasMany = array(
		'Source' => array(
			'className' => 'Source'
			)
		);

	//Kiem tra dau vao
	
}