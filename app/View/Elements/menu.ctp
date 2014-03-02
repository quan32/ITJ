<div>
	<ul>
		<li><?php 
		echo $this->Html->link('ログイン', 
			array('controller' => 'users', 'action' => 'login'));
			?></li>

		<li><?php 
		echo $this->Html->link('ログアウト ', 
			array('controller' => 'users', 'action' => 'logout'));
		?></li>
	</ul>
</div>