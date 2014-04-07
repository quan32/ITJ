<?php
class Search extends AppModel{
    var $name = "Search"; // Ten cua Model Search
	//tao lien ket giua 3 bang User, lecture va register
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
	public $validate = array(
        'slug' => array(
            'rule'    => 'alphaNumericDashUnderscore',
            'message' => '
			'
        )
    );

    public function alphaNumericDashUnderscore($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];

        return preg_match('|^[0-9a-zA-Z_-]*$|', $value);
    }
}