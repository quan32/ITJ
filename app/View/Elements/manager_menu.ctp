<div>
	<ul>
		<li><?php 
		echo $this->Html->link('User manager', 
			array('controller' => 'manages', 'action' => 'index'));
			?>
		</li>

		<li><?php 
		echo $this->Html->link('Accept', 
			array('controller' => 'manages', 'action' => 'accept'));
			?>
		</li>

		<li><?php 
		echo $this->Html->link('Change Ip', 
			array('controller' => 'manages', 'action' => 'change'));
		?></li>

		<li><?php 
		echo $this->Html->link('Change master data', 
			array('controller' => 'manages', 'action' => 'masterdata'));
		?></li>

		<li><?php 
		echo $this->Html->link('Lecture manager ', 
			array('controller' => 'manages', 'action' =>'lecture'));
		?></li>

		<li><?php 
		echo $this->Html->link('Add admin', 
			array('controller' => 'manages', 'action' => 'register'));
		?></li>

		<li><?php 
		echo $this->Html->link('Logout', 
			array('controller' => 'users', 'action' => 'logout'));
		?></li>

	</ul>
</div>