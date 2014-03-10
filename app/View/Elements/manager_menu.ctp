<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i>Manage User<b class="caret"></b></a>
  <ul class="dropdown-menu">
    <li><?php 
	echo $this->Html->link('Normal User', 
		array('controller' => 'manages', 'action' => 'index'));
		?>
	</li>

	<li><?php 
	echo $this->Html->link('New User', 
		array('controller' => 'manages', 'action' => 'accept'));
		?>
	</li>
  </ul>
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
<li><?php 
echo $this->Html->link('Admin statistic', 
	array('controller' => 'manages', 'action' => 'statistic'));
?></li>
 <li><?php 
echo $this->Html->link('Master data', 
	array('controller' => 'manages', 'action' => 'masterdata'));
?></li>
<li><?php 
echo $this->Html->link('Create oder', 
	array('controller' => 'manages', 'action' => 'oder'));
?></li>

<li><?php 
echo $this->Html->link('Logout ', 
	array('controller' => 'users', 'action' => 'logout'));
?></li>

