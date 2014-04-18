<?php
class Catagory extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			// 'required' => true,
			'message' => 'カテゴリ名を入力してください')
	);
	
}