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
		echo $this->Html->link('Lecture manager ', 
			array('controller' => 'manages', 'action' =>'lecture'));
		?></li>

		<li><?php 
		echo $this->Html->link('Add admin', 
			array('controller' => 'manages', 'action' => 'register'));
		?></li>

	</ul>
</div>