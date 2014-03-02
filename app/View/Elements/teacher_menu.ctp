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
		echo $this->Html->link('Add', 
			array('controller' => 'lectures', 'action' => 'add'));
		?></li>

	</ul>
</div>