<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i>Manage User<b class="caret"></b></a>
  <ul class="dropdown-menu">
    <li><?php 
	echo $this->Html->link('ユーザリスト', 
		array('controller' => 'manages', 'action' => 'index'));
		?>
	</li>

	<li><?php 
	echo $this->Html->link('新ユーザ', 
		array('controller' => 'manages', 'action' => 'accept'));
		?>
	</li>
  </ul>
</li>
<li><?php 
echo $this->Html->link('IPアドレス変化', 
	array('controller' => 'manages', 'action' => 'change'));
?></li>

<li><?php 
echo $this->Html->link('講義管理 ', 
	array('controller' => 'manages', 'action' =>'lecture'));
?></li>

<li><?php 
echo $this->Html->link('新管理者追加', 
	array('controller' => 'manages', 'action' => 'register'));
?></li>
<li><?php 
echo $this->Html->link('管理者に関する統計', 
	array('controller' => 'manages', 'action' => 'statistic'));
?></li>
 <li><?php 
echo $this->Html->link('マスターデータ', 
	array('controller' => 'manages', 'action' => 'masterdata'));
?></li>
<li><?php 
echo $this->Html->link('請求書作成', 
	array('controller' => 'manages', 'action' => 'oder'));
?></li>

<li><?php 
echo $this->Html->link('ログアウト ', 
	array('controller' => 'users', 'action' => 'logout'));
?></li>

