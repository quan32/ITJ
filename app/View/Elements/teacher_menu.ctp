<div>
	<ul>
		<li><?php 
		echo $this->Html->link('Homepage', 
			array('controller' => 'teachers', 'action' => 'index'));
			?></li>

		<li><?php 
		echo $this->Html->link('Information', 
			array('controller' => 'teachers', 'action' => 'info'));
		?></li>

		<li><?php 
		echo $this->Html->link('Lecture manager ', 
			array('controller' => 'lectures', 'action' =>'index'));
		?></li>

		<li><?php 
		echo $this->Html->link('Change Password', 
			array('controller' => 'teachers', 'action' => 'changePassword'));
		?></li>

		<li><?php 
		echo $this->Html->link('result', 
			array('controller' => 'teachers', 'action' => 'viewResult'));
		?></li>

		<li><?php 
		echo $this->Html->link('Statistic', 
			array('controller' => 'teachers', 'action' => 'statistic'));
		?></li>

	</ul>
</div>