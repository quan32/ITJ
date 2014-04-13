<?php
	class Report extends AppModel{
	//	public $belongsTo = array('Lecture','User');
		 var $name = "Report"; // 
	//tao lien ket giua 3 bang User, lecture va report
	public $useTable = 'reports'; 
		var $belongsTo = array(
			'User' => array(
				'className'     => 'User',
				'foreignKey'    => 'user_id'
			)
		);
		var $hasMany = array(
			'Lecture' => array(
				'className'     => 'Lecture',
				'foreignKey'    => 'lecture_id'
			)
		);
	}

?>