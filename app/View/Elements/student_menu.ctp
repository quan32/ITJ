<li><?php 
echo $this->Html->link('Homepage', 
	array('controller' => 'students', 'action' => 'index'));
	?></li>

<li><?php 
echo $this->Html->link('Information', 
	array('controller' => 'students', 'action' => 'view_info'));
?></li>
<li><?php 
echo $this->Html->link('Hien cac bai giang trong he thong', 
	array('controller' => 'students', 'action' => 'lectures_statistics'));
?></li>

<li><?php 
echo $this->Html->link('Hoc phi', 
	array('controller' => 'students', 'action' => 'money_this_month'));
?></li>

<li><?php 
echo $this->Html->link('thong ke cac bai test', 
	array('controller' => 'students', 'action' => 'results_statistics'));
?></li>

<li><?php 
echo $this->Html->link('Nhung bai giang dang ky', 
	array('controller' => 'students', 'action' => 'registed_lectures'));
?></li>
<li><?php 
echo $this->Html->link('Top cac bai hot trong he thong', 
	array('controller' => 'students', 'action' => 'top_lectures_hot'));
?></li>

<li><?php 
echo $this->Html->link('Change Password', 
	array('controller' => 'users', 'action' => 'changePassword'));
?></li>

<li><?php 
echo $this->Html->link('Logout ', 
	array('controller' => 'users', 'action' => 'logout'));
?></li>