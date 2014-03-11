<?php
class Block extends AppModel {
	public function isBlocked($teacher_id,$student_id){
		$tmp = $this->findAllByTeacherIdAndStudentId($teacher_id,$student_id);
		return count($tmp)!=0;
	}
	
}