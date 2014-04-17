<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> プロファイル管理 <b class="caret"></b></a>
  <ul class="dropdown-menu">
    <li><?php 
	echo $this->Html->link('自身情報', 
		array('controller' => 'manages', 'action' => 'viewinfo'));
	?></li>

	<li><?php 
	echo $this->Html->link('パスワード変更', 
		array('controller' => 'users', 'action' => 'changePassword'));
	?></li>
	<li><?php 
	echo $this->Html->link('Ip', 
		array('controller' => 'manages', 'action' => 'change'));
	?></li>
  </ul>
</li>

<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i>ユーザ管理<b class="caret"></b></a>
  <ul class="dropdown-menu">
    <li><?php 
	echo $this->Html->link('学生リスト', 
		array('controller' => 'manages', 'action' => 'index'));
		?>
	</li>
	<li><?php 
	echo $this->Html->link('先生リスト', 
		array('controller' => 'manages', 'action' => 'teacher'));
		?>
	</li>
	<li><?php 
	echo $this->Html->link('管理者リスト', 
		array('controller' => 'manages', 'action' => 'manager'));
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
<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i>講義管理<b class="caret"></b></a>
  <ul class="dropdown-menu">
    <li><?php 
	echo $this->Html->link('講義リスト', 
		array('controller' => 'manages', 'action' => 'lecture'));
		?>
	</li>

	<li><?php 
	echo $this->Html->link('レポート管理', 
		array('controller' => 'reports', 'action' => 'viewreports'));
		?>
	</li>
  </ul>
</li>

<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i>統計<b class="caret"></b></a>
  <ul class="dropdown-menu">
    <li><?php 
echo $this->Html->link('先生', 
	array('controller' => 'manages', 'action' => 'oder'));
?></li>

	<li><?php 
	echo $this->Html->link('管理者', 
		array('controller' => 'manages', 'action' => 'statistic'));
		?>
	</li>
  </ul>
</li>


<li><?php 
echo $this->Html->link('マスターデータ', 
	array('controller' => 'manages', 'action' => 'masterdata'));
?></li>


<li><?php 
echo $this->Html->link('バックアップ', 
	array('controller' => 'manages', 'action' => 'backup'));
?></li>


