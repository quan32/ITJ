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
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i>ユーザ管理<b class="caret"></b></a>
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
	<li><?php 
echo $this->Html->link('新管理者追加', 
	array('controller' => 'manages', 'action' => 'register'));
?></li>
  </ul>
</li>

<li><?php 
echo $this->Html->link('講義管理 ', 
	array('controller' => 'manages', 'action' =>'lecture'));
?></li>

<li><?php 
echo $this->Html->link('マスターデータ', 
	array('controller' => 'manages', 'action' => 'masterdata'));
?></li>
<li><?php 
echo $this->Html->link('請求書作成', 
	array('controller' => 'manages', 'action' => 'oder'));
?></li>

