<?php
class Comment extends AppModel{
	public $hasMany = array(
        'Reply' => array(
            'className' => 'Comment',
            'foreignKey' => 'parent_id',
            'order' => 'created ASC'
        )
    );
}
?>