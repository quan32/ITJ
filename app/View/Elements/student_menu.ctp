<div>
	<ul>
		<li><?php 
		echo $this->Html->link('Login', 
			array('controller' => 'users', 'action' => 'login'));
			?></li>

		<li><?php 
		echo $this->Html->link('Logout', 
			array('controller' => 'users', 'action' => 'logout'));
		?></li>
	</ul>
</div>