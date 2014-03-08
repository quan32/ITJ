<?php
class Test extends AppModel{
	public $hasOne = 'File';

	public $hasMany = array(
		'Result' => array(
			'className' => 'Result'
			)
		);
}
?>