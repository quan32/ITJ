<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> プロファイル管理 <b class="caret"></b></a>
  <ul class="dropdown-menu">
    <li><?php 
	echo $this->Html->link('自身情報', 
		array('controller' => 'teachers', 'action' => 'info'));
	?></li>

	<li><?php 
	echo $this->Html->link('パスワード変更', 
		array('controller' => 'users', 'action' => 'changePassword'));
	?></li>
  </ul>
</li>

<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> 講義管理 <b class="caret"></b></a>
  <ul class="dropdown-menu">
    <li><?php 
	echo $this->Html->link('新しい講義を作成', 
		array('controller' => 'lectures', 'action' =>'add'));
	?></li>

	<li><?php 
	echo $this->Html->link('講義リスト', 
		array('controller' => 'lectures', 'action' =>'index'));
	?></li>
  </ul>
</li>

<li><?php 
echo $this->Html->link('統計値', 
	array('controller' => 'teachers', 'action' => 'statistic'));
?></li>

