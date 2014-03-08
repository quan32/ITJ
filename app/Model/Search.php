<?php
	class Search extends AppModel{
		var $name = 'Search';
		public $useTable = 'lectures'; 
		var $belongsTo = array(
			'User' => array(
				'className'     => 'User',
				'foreignKey'    => 'user_id'
			)
		);
		var $hasMany = array(
			'Register' => array(
				'className'     => 'Register',
				'foreignKey'    => 'lecture_id'
			)
		);
	}
?>